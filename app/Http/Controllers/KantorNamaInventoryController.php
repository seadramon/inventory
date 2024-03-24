<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Models\InventoryName;
use Flasher\Prime\FlasherInterface;

use DB;
use Session;
use Validator;
use Storage;

class KantorNamaInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.kantor-nama-inventory.index');
    }

    public function data()
    {
        $query = InventoryName::select('*');
            
        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                $edit = '<div class="btn-group">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="' . route('master.kantor.nama.inventory.edit', ['kni' => $model->id]) . '">Edit</a></li>
                    <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
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
        return view('pages.kantor-nama-inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAsetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();
            
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
            ])->validate();

            $data = new InventoryName();
            $data->nama = $request->nama;

            $data->save();
            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('master.kantor.nama.inventory.index');
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
        $disabled = "disabled";
        $data = InventoryName::find($id);

        return view('pages.kantor-nama-inventory.create', [
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
                'nama' => 'required',
            ])->validate();

            $data = InventoryName::find($id);

            $data->nama = $request->nama;
            $data->save();

            DB::commit();
            $flasher->addSuccess('Data has been updated successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('master.kantor.nama.inventory.index');
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
            $data = InventoryName::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
