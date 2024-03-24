<?php

namespace App\Http\Controllers;

use App\Models\IkDocument;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Repositories\IkDocumentRepository;
use App\Repositories\SelectRepository;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IkDocumentController extends Controller
{
    protected $cats = ['perbaikan', 'perawatan', 'pengoperasian'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = null;

        return view('pages.ikdocument.index', [
            'data' => $data
        ]);
    }

    public function data()
    {
        $query = IkDocument::select('*');

        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                    $edit = '<div class="btn-group">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . route('ikdocument.edit', ['ikdocument' => $model->id]) . '">Edit</a></li>
                        <li><a class="dropdown-item" href="' . full_url_from_path($model->path_file) . '" target="_blank">Ik </a></li>
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
        $data = null;

        return view('pages.ikdocument.create', [
            'data' => $data
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
                'doc' => 'file|mimes:pdf',
            ])->validate();

            if ($request->hasFile('doc')) {
                $data = new IkDocument;

                $data->path_file = self::uploadFile($request->file('doc'));

                $data->save();
                DB::commit();
            }

            $flasher->addSuccess('Data has been saved successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('ikdocument.index');
    }

    private static function uploadFile($file, $pathfile = null)
    {
        if (!empty($pathfile)) {
            if ( Storage::disk('local')->exists($pathfile) ) {
                Storage::disk('local')->delete($pathfile);
            }
        }

        $extension = $file->getClientOriginalExtension();

        $dir = 'ik_docs/doc';
        cekDir($dir);

        $filename = '_'.trim(date('YmdHis')) . '.' . $extension;
        $fullpath = $dir.$filename;

        $up = Storage::disk('local')->put($fullpath, File::get($file));

        return $fullpath;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IkDocument  $ikDocument
     * @return \Illuminate\Http\Response
     */
    public function show(IkDocument $ikDocument)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IkDocument  $ikDocument
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = IkDocument::find($id);

        return view('pages.ikdocument.edit', [
            'data' => $data  
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IkDocument  $ikDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'doc' => 'file|mimes:pdf'
            ])->validate();

            if ($request->hasFile('doc')) {
                $data = IkDocument::find($id);
                
                if (empty($data)) {
                    $data = new IkDocument();
                    $data->path_file = self::uploadFile($request->file('doc'));
                } else {
                    $data->path_file = self::uploadFile($request->file('doc'));
                }

                $data->save();
                DB::commit();
            }
            foreach ($this->cats as $row) {
            }

            $flasher->addSuccess('Data has been saved successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('ikdocument.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IkDocument  $ikDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {               
            $data = IkDocument::find($request->id);

            if ( Storage::disk('local')->exists($data->path_file) ) {
                Storage::disk('local')->delete($data->path_file);
            }
            
            $data->delete();
            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
