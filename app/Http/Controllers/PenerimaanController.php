<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Penerimaan;
use Illuminate\Support\Str;
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

    public function wizard($id)
    {
        $nomorPendaftaran = 'PD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        $penerimaan = Penerimaan::findOrFail($id);
        return view('penerimaan.form', compact('penerimaan', 'nomorPendaftaran'));
    }

}
