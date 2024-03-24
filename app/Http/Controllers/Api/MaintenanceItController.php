<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Signature;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MaintenanceItController extends Controller
{
    public function store(Request $request){
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'no_inventaris'     => 'required',
                'no_tiket'          => 'required',
                'permasalahan'      => 'required',
                'diagnosa'          => 'required',
                'tindak_lanjut'     => 'required',
                'jenis_penanganan'  => 'required',
                'hasil'             => 'required',
                'sign'              => 'required',
            ])->validate();

            $maintenance                   = new Maintenance();
            $maintenance->no_inventaris    = $request->no_inventaris;
            $maintenance->no_tiket         = $request->no_tiket;
            $maintenance->permasalahan     = $request->permasalahan;
            $maintenance->diagnosa         = $request->diagnosa;
            $maintenance->tindak_lanjut    = $request->tindak_lanjut;
            $maintenance->jenis_penanganan = $request->jenis_penanganan;
            $maintenance->hasil            = $request->hasil;
            $maintenance->save();

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
			    $extension = $file->getClientOriginalExtension();

                $dir = 'maintenance/' . $maintenance->id;
			    cekDir($dir);

                $filename = 'foto.' . $extension;
			    $fullpath = $dir .'/'. $filename;

                Storage::disk('local')->put($fullpath, File::get($file));

			    $maintenance->foto_path = $fullpath;
                $maintenance->save();
            }

            // SIgnature
			$signature = new Signature;
			$signature->posisi = 'pelapor';
			$signature->sign_by = $request->created_by;

			$fullpath = "";
			if ($request->hasFile('sign')) {
			    $file = $request->file('sign');
			    $extension = $file->getClientOriginalExtension();

			    $dir = 'maintenance/' . $maintenance->id;
			    cekDir($dir);

			    $filename = 'pelapor.' . $extension;
			    $fullpath = $dir .'/'. $filename;

			    Storage::disk('local')->put($fullpath, File::get($file));

			    $signature->sign_path = $fullpath;
			}
            $maintenance->signature()->save($signature);
            DB::commit();

            return response()->json(array(
                'code'      => 200,
                'message'   => 'success',
                'data'      => null,
                200
            ));
        } catch(Exception $e) {
            DB::rollback();
        }

        return response()->json(array(
            'code'      => 400,
            'message'   => 'error',
            'data'      => null,
            400
        ));
    }
}
