<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Penerimaan;
use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $penerimaans = Penerimaan::where('dibuka_pada', '<=', $today)
                                            ->where('ditutup_pada', '>=', $today)
                                            ->latest()
                                            ->get();

        return view('penerimaan.list', compact('penerimaans'));
    }
}
