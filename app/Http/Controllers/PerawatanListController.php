<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Perawatan;
use Yajra\DataTables\Facades\DataTables;
use Flasher\Prime\FlasherInterface;
use DB;
use Validator;

class PerawatanListController extends Controller
{
    public function index(){
        // $query = Perawatan::with('assigns.form_perawatan')->get();
        // return response()->json($query);
        return view('pages.perawatan-list.index');
    }

    public function data()
    {
        $query = Perawatan::with('personal','assigns.form_perawatan')->select('*');
            
        return DataTables::eloquent($query)
                ->editColumn('created_by',function ($model){
                    return $model->personal->first_name. ' ' . $model->personal->last_name;
                })
                ->addColumn('menu', function ($model) {
                    $view = '';
                    if(!empty($model->id)){
                        $view = '<a class="btn btn-primary" href="'.route('perawatan.view', ['id' => $model->id]).'">View</a>';
                    }
                    return $view;
                })
                ->rawColumns(['menu'])
                ->toJson();
    }

    public function view($id)
    {
        $data = Perawatan::with('personal','assigns.form_perawatan','detail')
            ->find($id);
        return view('pages.perawatan-list.view' , ['data' => $data]);
    }
}
