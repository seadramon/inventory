<?php

namespace App\Http\Controllers;

use App\Models\TipePc;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function dashIt()
    {
        $tipepc = TipePc::all()->pluck('ket', 'kd_tipe_pc')->toArray();
        $labelTipepc = ["" => "All"];
        $tipepc = $labelTipepc + $tipepc;
    	return view('pages.dashboard.it', ['tipe_pc' => $tipepc]);
    }
}
