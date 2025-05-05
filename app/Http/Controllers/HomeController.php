<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Calendar;
use App\Models\Category;
use App\Models\Galeri;
use App\Models\Company;
use App\Models\HomeContent;
use Illuminate\Http\Request;
use App\Models\UnitPendidikan;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $company = Company::where('id', 1)->first();
        $homeContent = HomeContent::where('id', 1)->first();
        $units = UnitPendidikan::all();
        $galeris = Galeri::latest()->get();
        $artikels = Artikel::all();
        $categories = Category::all();
        $videos = Video::with('unitPendidikan')
            ->orderBy('created_at', 'desc')
            ->get();
        $pengumuman = Artikel::with('category')
            ->whereHas('category', function ($query) {
                $query->where('name', 'Pengumuman');
            })
            ->orderBy('created_at', 'desc')
            ->take(8) // atau sesuai kebutuhan
            ->get();
        $calendars = Calendar::select('title', 'start_date', 'end_date')->get();



        return view('dashboard', compact('company', 'homeContent', 'units', 'galeris', 'artikels', 'categories', 'pengumuman', 'videos', 'calendars'));

    }
}
