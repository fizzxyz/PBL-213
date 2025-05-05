<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitPendidikan;

class UnitPendidikanController extends Controller
{
    public function show($slug)
    {
        $unit = UnitPendidikan::where('slug', $slug)->firstOrFail();
        return view('unit', compact('unit'));
    }
}
