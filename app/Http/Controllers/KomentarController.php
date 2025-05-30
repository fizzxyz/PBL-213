<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Balasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    public function store(Request $request)
    {
        // Base validation
        $rules = [
            'artikel_id' => 'required|exists:artikels,id',
            'isi' => 'required|string|max:1000',
        ];

        // Tambah validasi untuk guest jika user tidak login
        if (!Auth::check()) {
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'required|email|max:255';
        }

        $request->validate($rules);

        $data = [
            'artikel_id' => $request->artikel_id,
            'isi' => $request->isi,
        ];

        // Jika user login, gunakan user_id
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        } else {
            // Jika guest, gunakan nama dan email
            $data['guest_name'] = $request->guest_name;
            $data['guest_email'] = $request->guest_email;
        }

        Komentar::create($data);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}