<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pc;
use App\Models\Software;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function itInventaris($kdWil, Request $request)
    {
    	$query = Pc::select(DB::raw("count(no_inventaris) as jml, tp.ket, tp.singkatan, tp.kd_pat"))
    		->join(DB::raw("wos.tb_pat tp"), 'inv_pc_h.kd_pat', '=', DB::raw("tp.kd_pat"))
    		->groupBy(DB::raw("tp.ket, tp.singkatan, tp.kd_pat"));

    	if ($kdWil != "0A") {
    		$query->where("inv_pc_h.kd_pat", $kdWil);
    	}
    	if ($request->tipe_pc != "") {
    		$query->where("inv_pc_h.kd_tipe_pc", $request->tipe_pc);
    	}

    	$query = $query->orderBy('kd_pat')->get();
    	
    	$data = [];
    	foreach ($query as $row) {
    		$data[] = [
    			"label" => $row->singkatan,
    			"value" => $row->jml
    		];
    	}

		$inventaris = (object)[
			"type" => "column2d",
			"width"=> "100%",
			"height"=> "100%",
			"dataFormat"=> "json",
			"dataSource" => [
				"chart" => [
					"caption"=> "Inventaris IT",
					"xaxisname"=> "Unit Kerja",
				    "yaxisname"=> "Jumlah Inventaris",
				    // "numbersuffix"=> "K",
				    "theme"=> "fusion"
				],
				"data" => $data
			]
		];

		return response()->json($inventaris)->setStatusCode(200, 'OK');
    }

    public function software($kdWil)
    {
    	$query = Software::select(DB::raw("count(software.id) as jml, tp.ket, tp.singkatan, tp.kd_pat"))
    		->join(DB::raw("wos.tb_pat tp"), 'software.kd_pat', '=', DB::raw("tp.kd_pat"))
    		->groupBy(DB::raw("tp.ket, tp.singkatan, tp.kd_pat"));

    	if ($kdWil != "0A") {
    		$query->where("software.kd_pat", $kdWil);
    	}

    	$query = $query->orderBy('kd_pat')->get();
    	
    	$data = [];
    	foreach ($query as $row) {
    		$data[] = [
    			"label" => $row->singkatan,
    			"value" => $row->jml
    		];
    	}

		$software = (object)[
			"type" => "column2d",
			"width"=> "100%",
			"height"=> "100%",
			"dataFormat"=> "json",
			"dataSource" => [
				"chart" => [
					"caption"=> "Software",
					"xaxisname"=> "Unit Kerja",
				    "yaxisname"=> "Jumlah Software",
				    // "numbersuffix"=> "K",
				    "theme"=> "fusion"
				],
				"data" => $data
			]
		];

		return response()->json($software)->setStatusCode(200, 'OK');
    }
}
