<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Yayasan;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function show($slug)
    {
        // Ambil artikel berdasarkan slug dengan relasi komentar dan balasan
        $artikel = Artikel::with([
            'user',
            'category',
            'unitPendidikans',
            'comments' => function($query) {
                $query->with(['user', 'balasans' => function($subQuery) {
                    $subQuery->with('user')->orderBy('created_at', 'asc');
                }])->orderBy('created_at', 'desc');
            }
        ])->where('slug', $slug)->firstOrFail();

        // Ambil yayasan (sesuaikan dengan logika Anda)
        $yayasan = Yayasan::first(); // atau sesuai kebutuhan

        // Previous Post - artikel sebelumnya berdasarkan ID
        $previousPost = Artikel::where('id', '<', $artikel->id)
            ->orderBy('id', 'desc')
            ->first();

        // Next Post - artikel selanjutnya berdasarkan ID
        $nextPost = Artikel::where('id', '>', $artikel->id)
            ->orderBy('id', 'asc')
            ->first();

        // Related Posts - artikel dengan kategori yang sama, kecuali artikel ini sendiri
        $relatedPosts = Artikel::where('category_id', $artikel->category_id)
            ->where('id', '!=', $artikel->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('artikel.show', compact('artikel', 'yayasan', 'previousPost', 'nextPost', 'relatedPosts'));
    }
}
