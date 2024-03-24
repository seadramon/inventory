<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Pc;
use Yajra\DataTables\Facades\DataTables;
use Flasher\Prime\FlasherInterface;
use Barryvdh\DomPDF\Facade\Pdf;

use DB;
use Session;
use Validator;
use Storage;

class MaintenanceController extends Controller
{
    public function index(){
        return view('pages.inventaris-it.maintenance.index');
        // return response()->json($data);
    }

    public function data()
    {
        $query = Maintenance::with('invpch.tipe_pc');

        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                    $edit = '<a class="btn btn-primary btn-sm" aria-expanded="false" href="'.route('maintenance-it.show', $model->id).'">
                                View
                            </a>';

                    return $edit;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function show($id){
        $data= Maintenance::with(['signature' => function($sql){
            $sql->with(['personal' => function($sql2){
                $sql2->select('employee_id','first_name','last_name');
            }])->first();
        }],'invpch.tipe_pc')->where('id',$id)->first();

        // return response()->json($data);
        return view('pages.inventaris-it.maintenance.show' , ['data' => $data]);
    }

    public function report()
    {
        $perangkat = Pc::selectRaw("no_inventaris, no_inventaris || ' | ' || pengguna as name")
            ->get()
            ->pluck('name', 'no_inventaris')
            ->toArray();
        $labelPerangkat = ["" => "- Pilih Perangkat -"];
        $perangkat = $labelPerangkat + $perangkat;

        return view('pages.inventaris-it.maintenance.report', [
            'perangkat' => $perangkat
        ]);
    }

    public function reportExport(Request $request, FlasherInterface $flasher)
    {
        try {
            $validator = Validator::make($request->all(), [
                'no_inventaris' => 'required'
            ])->validate();

            $data = Pc::find($request->no_inventaris);

            return Pdf::loadView('pages.inventaris-it.maintenance.report-pdf', [
                'data' => $data
            ])
            ->setPaper('a4', 'landscape')
            ->download('Maintenance IT.pdf');

        } catch(Exception $e) {
            $flasher->addError('An error has occurred please try again later.');
        }
    }
}
