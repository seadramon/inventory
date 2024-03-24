<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Software;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItSoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = null;

        return view('pages.it-software.index');
    }

    public function data()
    {
        $query = Software::select('*');
            
        return DataTables::eloquent($query)
                ->editColumn('expired', function ($model) {
                    return date('d-m-Y', strtotime($model->expired));
                })
                ->addColumn('menu', function ($model) {
                $edit = '<div class="btn-group">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="' . route('master.it-software.edit',  $model->id) . '">Edit</a></li>
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
        $jenisLisensi = ['software' => 'Software', 'perangkat' => 'Perangkat'];
        $labelJenisLisensi = ["" => "- Pilih Lisensi -"];
        $jenisLisensi = $labelJenisLisensi + $jenisLisensi;

        $tipeLangganan = ['tahunan' => 'Tahunan', 'bulanan' => 'Bulanan', 'lifetime' => 'Lifetime'];
        $labeltipeLangganan = ["" => "- Pilih Tipe Langganan -"];
        $tipeLangganan = $labeltipeLangganan + $tipeLangganan;
        return view('pages.it-software.create', [
            'jenis_lisensi' => $jenisLisensi,
            'tipe_langganan' => $tipeLangganan,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required'
            ])->validate();

            $data = new Software();
            $data->nama = $request->nama;
            $data->jenis_lisensi = $request->jenis_lisensi;
            if($request->jenis_lisensi == 'software'){
                $data->tipe_langganan = $request->tipe_langganan;
                $data->expired = date('Y-m-d', strtotime($request->expired));
                $data->email = $request->email;
                $data->serial_key = $request->serial_key;
            }

            $data->save();
            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('master.it-software.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Software::find($id);
        $jenisLisensi = ['software' => 'Software', 'perangkat' => 'Perangkat'];
        $labelJenisLisensi = ["" => "- Pilih Lisensi -"];
        $jenisLisensi = $labelJenisLisensi + $jenisLisensi;

        $tipeLangganan = ['tahunan' => 'Tahunan', 'bulanan' => 'Bulanan', 'lifetime' => 'Lifetime'];
        $labeltipeLangganan = ["" => "- Pilih Tipe Langganan -"];
        $tipeLangganan = $labeltipeLangganan + $tipeLangganan;

        return view('pages.it-software.create', [
            'data' => $data,
            'jenis_lisensi' => $jenisLisensi,
            'tipe_langganan' => $tipeLangganan
        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required'
            ])->validate();

            $data = Software::find($id);
            $data->nama = $request->nama;
            $data->jenis_lisensi = $request->jenis_lisensi;
            if($request->jenis_lisensi == 'software'){
                $data->tipe_langganan = $request->tipe_langganan;
                $data->expired = date('Y-m-d', strtotime($request->expired));
                $data->email = $request->email;
                $data->serial_key = $request->serial_key;
            }
            
            $data->save();

            DB::commit();
            $flasher->addSuccess('Data has been updated successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('master.it-software.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {               
            $data = Software::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
