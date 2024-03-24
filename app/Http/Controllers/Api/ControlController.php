<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Control;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Signature;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ControlController extends Controller
{
    public function store(Request $request){
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'no_inventaris' => 'required',
                'kelengkapan'   => 'required',
                'kondisi'       => 'required',
                'created_by'    => 'required'
            ])->validate();

            $control = new Control;
            $control->inventory_id  = $request->inventory_id;
            $control->kelengkapan   = $request->kelengkapan;
            $control->kondisi       = $request->kondisi;
            $control->keterangan    = $request->keterangan;
            $control->created_by    = $request->created_by;
            $control->save();

            DB::commit();

            return response()->json(array(
                'code'      => 200,
                'message'   => 'success',
                'data'      => null,
            ));
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(array(
                'code'      => 400,
                'message'   => $e->getMessage(),
                'data'      => null,
                400
            ));
        }

        
    }
}
