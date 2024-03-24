<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\FormPerawatan;
use App\Models\FormPerawatanDetail;
use Yajra\DataTables\Facades\DataTables;
use Flasher\Prime\FlasherInterface;
use DB;
use Validator;

class FormPerawatanItController extends Controller
{
    public function index(){
        return view('pages.form-perawatan-it.index');
    }

    public function data()
    {
        $query = FormPerawatan::with('detail')->select('*');
            
        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                    $edit = '<div class="btn-group">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . route('form-perawatan-it.edit', $model->id) . '">Edit</a></li>
                        <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                    </ul>
                    </div>';

                    return $edit;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create()
    {
        return view('pages.form-perawatan-it.create');
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama'              => 'required'
            ])->validate();

            $data       = new FormPerawatan();
            $data->nama = $request->nama;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data telah berhasil dibuat!');
        } catch(Exception $e) {
            DB::rollback();

            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('form-perawatan-it.edit', $data->id);
    }

    public function edit($id)
    {
        $data = FormPerawatan::find($id);

        return view('pages.form-perawatan-it.create', compact('data'));   
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

        	Validator::make($request->all(), [
                'nama'          => 'required'
            ])->validate();

            $formPerawatan              = FormPerawatan::find($id);
            $formPerawatan->nama        = $request->nama;
            $formPerawatan->save();

            //Detail
            $detailIds = array();

            foreach(($request->form_perawatan_detail ?? []) as $detail){
                $arrayPilihan = json_decode($detail['pilihan'] ?? null) ?? [];
                $listPilihan = [];

                foreach($arrayPilihan as $pilihan){
                    $listPilihan[] = $pilihan->value;
                }

                $detailIds[] = FormPerawatanDetail::updateOrCreate([
                    'id'        => $detail['id_detail'] ?? 0,
                ],[
                    'form_perawatan_id' => $id,
                    'nama'              => $detail['nama_detail'],
                    'jenis'             => $detail['jenis'],
                    'parameter'         => Str::of($detail['nama_detail'])->snake()->value,
                    'pilihan'           => !empty($listPilihan) ? implode('|', $listPilihan) : '',
                    'foto_needed'       => isset($detail['foto_needed']) ? 1 : 0,
                    'keterangan_needed' => isset($detail['keterangan_needed']) ? 1 : 0,
                ])->id;
            }

            if(!empty($detailIds)){
                $formPerawatan->detail()->whereNotIn('id', $detailIds)->delete();
            }else{
                $formPerawatan->detail()->delete();
            }

            DB::commit();

            $flasher->addSuccess('Data telah berhasil diperbarui!');
        } catch(Exception $e) {
            DB::rollback();

            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('form-perawatan-it.edit', $id);
    }
    
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {               
            $data = FormPerawatan::find($request->id);

            $data->detail()->delete();
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
