<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipePc;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TipePcController extends Controller
{
    public function index(){
        return view('pages.tipe-pc.index');
    }

    public function data()
    {
        $query = TipePc::select('*');

        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                    $edit = '<div class="btn-group">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="' . route('master.tipe-pc.edit', $model->kd_tipe_pc) . '">Edit</a></li>
                                <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->kd_tipe_pc. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                            </ul>
                            </div>';

                    return $edit;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create()
    {
        return view('pages.tipe-pc.create');
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'kd_tipe_pc'    => 'required|unique:tb_tipe_pc',
                'kode'          => 'required',
                'depresiasi'    => 'required',
                'ket'           => 'required'
            ])->validate();

            $data = new TipePc();
            $data->kd_tipe_pc = $request->kd_tipe_pc;
            $data->kode       = $request->kode;
            $data->ket        = $request->ket;
            $data->depresiasi = $request->depresiasi;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data telah berhasil dibuat!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('master.tipe-pc.index');
    }

    public function edit($id)
    {
        $data = TipePc::find($id);

        return view('pages.tipe-pc.create', [
            'data' => $data
        ]);
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
        	$validator = Validator::make($request->all(), [
                'kd_tipe_pc' => 'required',
                'kode'       => 'required',
                'depresiasi' => 'required',
                'ket'        => 'required'
            ])->validate();

            $data = TipePc::find($id);
            $data->kode       = $request->kode;
            $data->ket        = $request->ket;
            $data->depresiasi = $request->depresiasi;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data telah berhasil diperbarui!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('master.tipe-pc.index');
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = TipePc::find($request->kd_tipe_pc);
            $data->delete();
            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
