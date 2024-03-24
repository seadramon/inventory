<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemPc;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemPcController extends Controller
{
    public function index(){
        return view('pages.item-pc.index');
    }

    public function data()
    {
        $query = ItemPc::select('*');
            
        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                    $edit = '<div class="btn-group">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . route('master.item-pc.edit', $model->kd_item) . '">Edit</a></li>
                        <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->kd_item. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                    </ul>
                    </div>';

                    return $edit;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create()
    {
        return view('pages.item-pc.create');
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'kd_item'       => 'required|unique:tb_item',
                'ket'           => 'required'
            ])->validate();

            $data               = new ItemPc();
            $data->kd_item      = $request->kd_item;
            $data->ket          = $request->ket;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data telah berhasil dibuat!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('master.item-pc.index');
    }

    public function edit($id)
    {
        $data = ItemPc::find($id);

        return view('pages.item-pc.create', [
            'data' => $data
        ]);   
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
        	$validator = Validator::make($request->all(), [
                'kd_item'       => 'required',
                'ket'           => 'required'
            ])->validate();

            $data = ItemPc::find($id);

            $data->ket = $request->ket;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data telah berhasil diperbarui!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('master.item-pc.index');
    }
    
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {               
            $data = ItemPc::find($request->kd_item);

            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
