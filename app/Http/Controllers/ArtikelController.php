<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function show($slug)
    {
        // Mengambil artikel berdasarkan slug
        $artikel = Artikel::where('slug', $slug)->firstOrFail();

        return view('artikel.show', compact('artikel'));
    }
}
