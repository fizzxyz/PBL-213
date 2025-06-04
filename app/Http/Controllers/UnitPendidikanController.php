<?php

namespace App\Http\Controllers;

use App\Models\Yayasan;
use Illuminate\Http\Request;
use App\Models\UnitPendidikan;

class UnitPendidikanController extends Controller
{
    /**
     * Menampilkan halaman utama unit pendidikan
     */
    public function show($slug)
    {
        $unit = UnitPendidikan::where('slug', $slug)->firstOrFail();

        // Data untuk navbar (jika diperlukan)
        $yayasan = Yayasan::first();
        $units = UnitPendidikan::with('navbars')->get();

        return view('unit.show', compact('unit', 'yayasan', 'units'));
    }

    /**
     * Menampilkan halaman tentang unit pendidikan
     */
    public function tentang($slug)
    {
        $unit = UnitPendidikan::where('slug', $slug)->firstOrFail();

        // Data untuk navbar (jika diperlukan)
        $yayasan = Yayasan::first();
        $units = UnitPendidikan::with('navbars')->get();

        return view('unit.show', compact('unit', 'yayasan', 'units'));
    }
}
