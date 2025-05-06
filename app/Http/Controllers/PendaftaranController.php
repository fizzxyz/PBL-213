<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'usia' => 'required|integer',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'required|string',
            'nomor_pendaftaran' => 'required|string',
            'pas_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'skhu' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $pendaftaran = new Pendaftaran();
        $pendaftaran->user_id = auth()->id(); // pastikan user sudah login
        $pendaftaran->penerimaan_id = request()->route('id') ?? $request->input('penerimaan_id'); // bisa dari route atau input
        $pendaftaran->nomor_pendaftaran = $request->nomor_pendaftaran;
        $pendaftaran->nama_lengkap = $request->nama_lengkap;
        $pendaftaran->usia = $request->usia;
        $pendaftaran->jenis_kelamin = $request->jenis_kelamin;
        $pendaftaran->alamat = $request->alamat;

        // Simpan file
        $pendaftaran->path_foto = $request->file('pas_foto')->store('pendaftaran/foto', 'public');
        $pendaftaran->path_ijazah = $request->file('ijazah')->store('pendaftaran/ijazah', 'public');
        $pendaftaran->path_skhu = $request->file('skhu')->store('pendaftaran/skhu', 'public');

        $pendaftaran->status_pendaftaran = 'pending';
        $pendaftaran->save();

        // Buat transaksi di tabel `transaksis`
        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = 'TRX-' . strtoupper(Str::random(10));
        $transaksi->user_id = auth()->id();
        $transaksi->pendaftaran_id = $pendaftaran->id;
        $transaksi->total = $pendaftaran->penerimaan->biaya ?? 0;
        $transaksi->is_paid = false;
        $transaksi->save();

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat payload Snap
        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->kode_transaksi,
                'gross_amount' => $transaksi->total,
            ],
            'customer_details' => [
                'first_name' => $pendaftaran->nama_lengkap,
                'email' => auth()->user()->email ?? 'user@example.com',
            ],
            'callbacks' => [
                'finish' => route('transaksi.finish'),
            ],
        ];

        // Dapatkan Snap URL
        $snapUrl = Snap::createTransaction($params)->redirect_url;

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'redirect_url' => $snapUrl,
        ], 201);
    }
}
