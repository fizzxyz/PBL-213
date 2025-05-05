<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function show($slug)
    {
        $galeri = Galeri::where('slug', $slug)->firstOrFail();
        return view('galeri', compact('galeri'));
    }

}
