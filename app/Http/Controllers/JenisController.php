<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jenis;
use Yajra\DataTables\Facades\DataTables;
use Flasher\Prime\FlasherInterface;
use DB;
use Session;
use Validator;
use Storage;

class JenisController extends Controller
{
    public function index(){
        return view('pages.jenis.index');
    }

    public function data()
    {
        $query = Jenis::select('*');
            
        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                    $edit = '<div class="btn-group">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . route('master.jenis.edit', $model->id) . '">Edit</a></li>
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
        return view('pages.jenis.create');
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'code'  => 'required',
                'name'  => 'required'
            ])->validate();

            $data        = new Jenis();
            $data->code  = $request->code;
            $data->name  = $request->name;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data telah berhasil dibuat!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('master.jenis.index');
    }

    public function edit($id)
    {
        $data = Jenis::find($id);

        return view('pages.jenis.create', [
            'data' => $data
        ]);   
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
        	$validator = Validator::make($request->all(), [
                'code'       => 'required',
                'name'       => 'required'
            ])->validate();

            $data = Jenis::find($id);

            $data->code  = $request->code;
            $data->name  = $request->name;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data telah berhasil diperbarui!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('master.jenis.index');
    }
    
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {               
            $data = Jenis::find($request->id);

            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
