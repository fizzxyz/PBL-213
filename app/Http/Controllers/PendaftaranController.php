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
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'penerimaan_id' => 'required|exists:penerimaans,id',
        'nomor_pendaftaran' => 'required|string',
        'nama_lengkap' => 'required|string',
        'usia' => 'required|integer',
        'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        'alamat' => 'required|string',
        'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png',
        'pas_foto' => 'required|file|mimes:jpg,jpeg,png',
        'skhu' => 'required|file|mimes:pdf,jpg,jpeg,png',
    ]);

    $path_ijazah = $request->file('ijazah')->store('uploads/ijazah', 'public');
    $path_foto = $request->file('pas_foto')->store('uploads/foto', 'public');
    $path_skhu = $request->file('skhu')->store('uploads/skhu', 'public');

    $pendaftaran = \App\Models\Pendaftaran::create([
        'user_id' => $request->user_id,
        'penerimaan_id' => $request->penerimaan_id,
        'nomor_pendaftaran' => $request->nomor_pendaftaran,
        'nama_lengkap' => $request->nama_lengkap,
        'usia' => $request->usia,
        'jenis_kelamin' => $request->jenis_kelamin,
        'alamat' => $request->alamat,
        'path_ijazah' => $path_ijazah,
        'path_foto' => $path_foto,
        'path_skhu' => $path_skhu,
        'status_pendaftaran' => 'pending',
    ]);

    return response()->json(['success' => true, 'id' => $pendaftaran->id]);
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