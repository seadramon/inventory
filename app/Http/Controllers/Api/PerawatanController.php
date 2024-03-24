<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Perawatan;
use App\Models\PerawatanDetail;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PerawatanController extends Controller
{
    
    public function store(Request $request)
    {
    	try {
    		DB::beginTransaction();

    		$data = new Perawatan;
    		$data->kd_pat = $request->kd_pat;
    		$data->created_by = $request->created_by;
    		$data->save();
// dd($data->detail);
    		if (!empty($request->forms)) {
    			foreach ($request->forms as $key => $row) {
    				$detail = new PerawatanDetail;

    				$detail->nama = !empty($row['nama'])?$row['nama']:"";
    				$detail->value = !empty($row['value'])?$row['value']:"";
    				$detail->keterangan = !empty($row['keterangan'])?$row['keterangan']:"";

    				if ($request->hasFile("forms.$key.foto")) {
					    $file = $request->file("forms.$key.foto");
					    $extension = $file->getClientOriginalExtension();

					    $dir = 'perawatan/'.$data->id;
					    cekDir($dir);

					    $filename = 'perawatan_detail_'.$key.'.jpg';
					    $fullpath = $dir .'/'. $filename;

					    Storage::disk('local')->put($fullpath, File::get($file));

					    $detail->foto = $fullpath;
					}

                    $data->detail()->save($detail);
    			}
    		}

            DB::commit();

            return response()->json(array(
                'code'      => 200,
                'message'   => 'success',
                'data'      => null,
                200
            ));
    	} catch(Exception $e) {
            DB::rollback();

            return response()->json(array(
                'code'      => 400,
                'message'   => 'error',
                'data'      => $e->getMessage(),
                400
            ));
    	}
    }
}
