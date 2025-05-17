<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pendaftaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Log untuk debugging
            Log::info('Menerima request pendaftaran', $request->except(['pas_foto', 'ijazah', 'skhu']));

            // Validate request - No need to modify this part since we're not checking against table names
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'usia' => 'required|integer',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'alamat' => 'required|string',
                'nomor_pendaftaran' => 'required|string',
                'pas_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
                'skhu' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
                'penerimaan_id' => 'required', // Removed exists validation
            ]);

            // Cek apakah sudah ada pendaftaran dengan nomor pendaftaran yang sama
            $existingRegistration = Pendaftaran::where('nomor_pendaftaran', $request->nomor_pendaftaran)
                ->where('user_id', auth()->id())
                ->first();

            if ($existingRegistration) {
                // Jika sudah ada, gunakan yang ada daripada membuat baru
                Log::info('Pendaftaran dengan nomor yang sama sudah ada', ['id' => $existingRegistration->id]);
                return response()->json([
                    'message' => 'Data pendaftaran sudah ada',
                    'pendaftaran_id' => $existingRegistration->id,
                    'transaksi_id' => $existingRegistration->transaksi->id ?? null,
                ], 200);
            }

            // Jika belum ada, buat pendaftaran baru
            $pendaftaran = new Pendaftaran();
            $pendaftaran->user_id = auth()->id();
            $pendaftaran->penerimaan_id = $request->penerimaan_id;
            $pendaftaran->nomor_pendaftaran = $request->nomor_pendaftaran;
            $pendaftaran->nama_lengkap = $request->nama_lengkap;
            $pendaftaran->usia = $request->usia;
            $pendaftaran->jenis_kelamin = $request->jenis_kelamin;
            $pendaftaran->alamat = $request->alamat;

            // Store files
            $pendaftaran->path_foto = $request->file('pas_foto')->store('pendaftaran/foto', 'public');
            $pendaftaran->path_ijazah = $request->file('ijazah')->store('pendaftaran/ijazah', 'public');
            $pendaftaran->path_skhu = $request->file('skhu')->store('pendaftaran/skhu', 'public');

            $pendaftaran->status_pendaftaran = 'pending';
            $pendaftaran->save();

            Log::info('Pendaftaran baru dibuat', ['id' => $pendaftaran->id]);

            // // Buat transaksi baru
            // $transaksi = new Transaksi();
            // $transaksi->kode_transaksi = 'TRX-' . strtoupper(Str::random(10));
            // $transaksi->user_id = auth()->id();
            // $transaksi->pendaftaran_id = $pendaftaran->id;
            // $transaksi->total = $request->has('total_biaya') ? $request->total_biaya : 0;
            // $transaksi->is_paid = false;
            // $transaksi->save();

            // Log::info('Transaksi baru dibuat', ['id' => $transaksi->id]);

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'pendaftaran_id' => $pendaftaran->id,
                // 'transaksi_id' => $transaksi->id,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors specifically
            Log::error('Validation error in store pendaftaran', [
                'errors' => $e->errors(),
            ]);

            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {
            Log::error('Error dalam store pendaftaran: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'message' => 'Terjadi error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function riwayat()
    {
        $user = Auth::user();
        $riwayat = Pendaftaran::with(['transaksi'])
            ->where('user_id', auth()->id())
            ->get();

        return view('penerimaan.riwayat', compact('riwayat'));
    }
}