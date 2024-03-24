<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Merk;
use Flasher\Prime\FlasherInterface;

use DB;
use Session;
use Validator;
use Storage;

class MerkKantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = null;

        return view('pages.merk.kantor.index');
    }

    public function data()
    {
        $query = Merk::where('type','KANTOR')->select('*');
            
        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                $edit = '<div class="btn-group">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="' . route('master.merk.kantor.edit',  $model->kd_merk) . '">Edit</a></li>
                    <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->kd_merk. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                  </ul>
                </div>';
                return $edit;
            })
            ->rawColumns(['menu'])
                ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.merk.kantor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAsetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FlasherInterface $flasher)
    {
        DB::beginTransaction();
// dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'kd_merk' => 'required|unique:tb_merk',
                'ket' => 'required'
            ])->validate();

            $data = new Merk();
            // dd($data); 
            $data->kd_merk = $request->kd_merk;
            $data->type = 'KANTOR';
            $data->ket = $request->ket;

            $data->save();
            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('master.merk.kantor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $disabled = "disabled";
        $data = Merk::find($id);

        return view('pages.merk.kantor.create', [
            'data' => $data
        ]);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAsetRequest  $request
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
        	$validator = Validator::make($request->all(), [
                'kd_merk' => 'required',
                'ket' => 'required'
            ])->validate();

            $data = Merk::find($id);
            $data->ket = $request->ket;
            
            $data->save();

            DB::commit();
            $flasher->addSuccess('Data has been updated successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('master.merk.kantor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {               
            $data = Merk::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
