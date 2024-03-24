<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TipePc;
use App\Models\Merk;
use App\Models\Pat;
use App\Models\Gas;
use App\Models\PcDetail;
use App\Models\PcSoftware;
use App\Models\Software;
use App\Models\ItemPc;
use App\Models\Pc;
use App\Models\Personal;

use Yajra\DataTables\Facades\DataTables;
use Flasher\Prime\FlasherInterface;
use Barryvdh\DomPDF\Facade\Pdf;

use DB;
use Session;
use Validator;
use Storage;

class InventarisItController extends Controller
{
    public function index(){
        return view('pages.inventaris-it.index');
    }

    public function data()
    {
        $query = Pc::with('pat')
            ->with('tipe_pc')
            ->select('*');
        if (session('TMP_KDWIL') != "0A") {
            $query->where("kd_pat", session('TMP_KDWIL'));
        }
    

        return DataTables::eloquent($query)
                ->editColumn('tgl_perolehan', function ($model) {
                    if(!$model->tgl_perolehan){
                        return '-';
                    }
                    return date('d-m-Y', strtotime($model->tgl_perolehan));
                })
                ->addColumn('menu', function ($model) {
                    $edit = '<div class="btn-group">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . route('inventaris-it.edit', str_replace('/', '|', $model->no_inventaris)) . '">Edit</a></li>
                        <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->no_inventaris. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                    </ul>
                    </div>';

                    return $edit;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create()
    {
        $data = null;

    	$tipepc = TipePc::all()->pluck('ket', 'kd_tipe_pc')->toArray();
        $labelTipepc = ["" => "- Pilih Tipe Perangkat -"];
        $tipepc = $labelTipepc + $tipepc;

        $merk = Merk::all()->pluck('ket', 'kd_merk')->toArray();
        $labelMerk = ["" => "- Pilih Merk -"];
        $merk = $labelMerk + $merk;

        $pat = Pat::all()->pluck('ket', 'kd_pat')->toArray();
        $labelPat = ["" => "- Pilih PAT/PPU -"];
        $pat = $labelPat + $pat;

        $gas = Gas::all()->pluck('ket', 'kd_gas')->toArray();
        $labelGas = ["" => "- Pilih Biro -"];
        $gas = $labelGas + $gas;

        $status = ["" => "Pilih Status",
        	"1" => "Aktif",
        	"2" => "Standby",
        	"3" => "Maintenance",
        	"0" => "Rusak/Tidak bisa dipakai"
        ];

        $tipePengguna = ["" => "Pilih Tipe Pengguna",
        	"personal"  => "Personal",
        	"unit"      => "Unit",
        ];

        // $pengguna = Personal::all()->pluck('pengguna', 'employee_id')->toArray();
        // $labelPengguna = ["" => "- Pilih Pegguna -"];
        // $pengguna = $labelPengguna + $pengguna;


    	return view('pages.inventaris-it.create',[
    		'tipe' => $tipepc,
    		'merk' => $merk,
    		'pat' => $pat,
    		'gas' => $gas,
    		'status' => $status,
            'tipe_pengguna' => $tipePengguna,
            // 'pengguna' => $pengguna,
            'data' => $data
    	]);
    }

    public function getDataPersonal(Request $request){
        $data = Personal::select('employee_id','first_name','last_name')
                ->where('first_name','LIKE','%'.$request->q.'%')
                ->orWhere('last_name','LIKE','%'.$request->q.'%')
                ->orwhere('employee_id','LIKE','%'.$request->q.'%')
                ->get();
        return $data; // abd
    }

    public function edit($id)
    {
        $data = Pc::find(str_replace('|', '/', $id));

        $tipepc = TipePc::all()->pluck('ket', 'kd_tipe_pc')->toArray();
        $labelTipepc = ["" => "- Pilih Tipe Perangkat -"];
        $tipepc = $labelTipepc + $tipepc;

        $merk = Merk::all()->pluck('ket', 'kd_merk')->toArray();
        $labelMerk = ["" => "- Pilih Merk -"];
        $merk = $labelMerk + $merk;

        $pat = Pat::all()->pluck('ket', 'kd_pat')->toArray();
        $labelPat = ["" => "- Pilih PAT/PPU -"];
        $pat = $labelPat + $pat;

        $gas = Gas::all()->pluck('ket', 'kd_gas')->toArray();
        $labelGas = ["" => "- Pilih Biro -"];
        $gas = $labelGas + $gas;

        $status = ["" => "Pilih Status",
        	"1" => "Aktif",
        	"2" => "Standby",
        	"3" => "Maintenance",
        	"0" => "Rusak/Tidak bisa dipakai"
        ];

        $tipePengguna = ["" => "Pilih Tipe Pengguna",
        	"personal"  => "Personal",
        	"unit"      => "Unit",
        ];

        // $pengguna = Personal::where('kd_pat', session('TMP_KDWIL'))->take(10)->get()->pluck('pengguna', 'employee_id')->toArray();
        // $labelPengguna = ["" => "- Pilih Pegguna -"];
        // $pengguna = $labelPengguna + $pengguna;

        $pengguna = Personal::where('employee_id', $data->employee_id)->first();

        $itempc = ItemPc::all()->pluck('ket', 'kd_item')->toArray();
        $labelitem = ["" => "- Pilih Item -"];
        $itempc = $labelitem + $itempc;

        $satuan = config('custom.satuan');

        $software = Software::all()->mapWithKeys(function ($item, $key){ return [$item->id . '#' . $item->jenis_lisensi => $item->nama]; })->all();
        $labelSoftware = ["" => "- Pilih Software -"];
        $software = $labelSoftware + $software;

        $jenisLisensi = ['software' => 'Software', 'perangkat' => 'Perangkat'];
        $labelJenisLisensi = ["" => "- Pilih Lisensi -"];
        $jenisLisensi = $labelJenisLisensi + $jenisLisensi;

        $tipeLangganan = ['tahunan' => 'Tahunan', 'bulanan' => 'Bulanan', 'lifetime' => 'Lifetime'];
        $labeltipeLangganan = ["" => "- Pilih Tipe Langganan -"];
        $tipeLangganan = $labeltipeLangganan + $tipeLangganan;

        return view('pages.inventaris-it.edit',[
            'tipe' => $tipepc,
            'merk' => $merk,
            'pat' => $pat,
            'gas' => $gas,
            'status' => $status,
            'tipe_pengguna' => $tipePengguna,
            'pengguna' => $pengguna,
            'itempc' => $itempc,
            'satuan' => $satuan,
            'data' => $data,
            'software' => $software,
            'jenis_lisensi' => $jenisLisensi,
            'tipe_langganan' => $tipeLangganan,
        ]);
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();
                        
            $validator = Validator::make($request->all(), [
                'kd_tipe_pc' => 'required',
                'tipe_pengguna' => 'required',
                'tgl_perolehan' => 'required',
            ])->validate();

            $data = new Pc();
            $data->kd_tipe_pc = $request->kd_tipe_pc;
            $data->tipe_pengguna = $request->tipe_pengguna;
            $data->kd_merk = $request->kd_merk;
            $data->model = $request->model;
            $data->kd_pat = $request->kd_pat;
            $data->kd_gas = $request->kd_gas;
            $data->pc_name = $request->pc_name;
            $data->workgroup = $request->workgroup;
            $data->domain = $request->domain;
            $data->ip4_address = $request->ip4_address;
            $data->mac_address = $request->mac_address;
            $data->hrg_perolehan = str_replace(',','',$request->hrg_perolehan);
            $data->tgl_perolehan = date('Y-m-d', strtotime($request->tgl_perolehan));
            $data->status = $request->status ?? 0;

            $noregSeq = Pc::max('no_registrasi');
            $data->no_registrasi = $noregSeq ? ($noregSeq + 1) : 1;
            $request->merge(['no_registrasi' => $data->no_registrasi]);

            if($request->tipe_pengguna == 'personal'){
                $personal = Personal::find($request->pengguna);
                $data->employee_id = $personal->employee_id;
                $data->pengguna = $personal->first_name . ' ' . $personal->last_name;
            }else{
                $gas = Gas::find($request->kd_gas);
                $data->pengguna = $gas->ket ?? null;
            }

            $data->no_inventaris = generateNoInventarisIt($request);

            $data->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('inventaris-it.edit', ['inventaris_it'=>$data->no_inventaris]);
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'kd_tipe_pc' => 'required',
                'tipe_pengguna' => 'required',
                'tgl_perolehan' => 'required',
            ])->validate();

            $data = Pc::find($id);

            $data->kd_tipe_pc = $request->kd_tipe_pc;
            $data->tipe_pengguna = $request->tipe_pengguna;
            $data->kd_merk = $request->kd_merk;
            $data->model = $request->model;
            $data->kd_pat = $request->kd_pat;
            $data->kd_gas = $request->kd_gas;
            $data->pc_name = $request->pc_name;
            $data->workgroup = $request->workgroup;
            $data->domain = $request->domain;
            $data->ip4_address = $request->ip4_address;
            $data->mac_address = $request->mac_address;
            $data->hrg_perolehan = str_replace(',','',$request->hrg_perolehan);
            $data->tgl_perolehan = date('Y-m-d', strtotime($request->tgl_perolehan));
            $data->status = $request->status ?? 0;

            if($request->tipe_pengguna == 'personal'){
                $personal = Personal::find($request->pengguna);
                $data->employee_id = $personal->employee_id;
                $data->pengguna = $personal->first_name . ' ' . $personal->last_name;
            }else{
                $gas = Gas::find($request->kd_gas);
                $data->pengguna = $gas->ket ?? null;
            }

            $data->save();

            DB::commit();
            $flasher->addSuccess('Data has been updated successfully!');
        } catch(Exception $e) {
            DB::rollback();
            $flasher->addError('An error has occurred please try again later.');
        }

        return redirect()->route('inventaris-it.edit', ['inventaris_it'=>$data->no_inventaris]);
    }

    public function dataDetail($id)
    {
        $query = PcDetail::with(['item', 'merk'])->where('no_inventaris', str_replace('|', '/', $id));
            
        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                $json = http_build_query([
                    'kd_item' => $model->kd_item,
                    'no_urut' => $model->no_urut,
                    'kd_merk' => $model->kd_merk,
                    'spesifikasi' => $model->spesifikasi,
                    'tipe' => $model->tipe,
                    'kapasitas' => $model->kapasitas,
                    'satuan' => $model->satuan,
                ]);
                
                $editlink = "<li><a class='dropdown-item edit-detail' href='javascript:void(0)' data-id='$model->no_inventaris' data-json='$json'>Edit</a></li>";

                $edit = '<div class="btn-group">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                  </button>
                  <ul class="dropdown-menu">
                    '.$editlink.'
                    <li><a class="dropdown-item delete-detail" href="javascript:void(0)" data-id="' .$model->no_inventaris. '" data-item="'.$model->kd_item.'" data-urut="'.$model->no_urut.'" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                  </ul>
                </div>';
                return $edit;
            })
            ->rawColumns(['menu'])
                ->toJson();
    }

    public function storeDetail(Request $request, FlasherInterface $flasher)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kd_item' => 'required',
                'kd_merk' => 'required',
                'kapasitas' => 'numeric',
            ])->validate();

            DB::beginTransaction();

            if (empty($request->no_urut)) {
                $check = PcDetail::where('no_inventaris', $request->no_inventaris)
                    ->where('kd_item', $request->kd_item);

                if ($check->count() > 0) {
                    $noUrut = $check->max('no_urut') + 1;
                } else {
                    $noUrut = 1;
                }

                $data = new PcDetail;

                $data->no_inventaris = $request->no_inventaris;
                $data->kd_item = $request->kd_item;
                $data->kd_merk = $request->kd_merk;
                $data->spesifikasi = $request->spesifikasi;
                $data->tipe = $request->tipe;
                $data->kapasitas = $request->kapasitas;
                $data->satuan = $request->satuan;
                $data->no_urut = $noUrut;

                $data->save();
            } else {
                $noUrut = $request->no_urut;
                // dd($request->kd_item.'|'.$request->no_inventaris.'|'.$noUrut);

                $data = PcDetail::where('no_inventaris', $request->no_inventaris)
                    ->where('kd_item', $request->kd_item)
                    ->where('no_urut', $noUrut)
                    ->update([
                        'kd_item' => $request->kd_item,
                        'kd_merk' => $request->kd_merk,
                        'spesifikasi' => $request->spesifikasi,
                        'tipe' => $request->tipe,
                        'kapasitas' => $request->kapasitas,
                        'satuan' => $request->satuan,
                        'no_urut' => $noUrut,
                    ]);
            }

            DB::commit();
        } catch(Exception $e) {
            DB::rollback();
        }
    }

    public function destroyDetail(Request $request)
    {
        DB::beginTransaction();

        try {               
            $data = PcDetail::where('no_inventaris', $request->id)
                ->where('kd_item', $request->item)
                ->where('no_urut', $request->urut)
                ->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Pc::find($request->id);

            if (empty($data)) {
                throw new \Exception('Data Not found');
            }

            $data->pcDetail()?->delete();
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

    public function dataSoftware($id)
    {
        $query = PcSoftware::with('software')->where('no_inventaris', str_replace('|', '/', $id));
            
        return DataTables::eloquent($query)
                ->editColumn('tipe_langganan', function ($model) {
                    return $model->software->jenis_lisensi == 'software' ? $model->software->tipe_langganan : $model->tipe_langganan;
                })
                ->editColumn('email', function ($model) {
                    return $model->software->jenis_lisensi == 'software' ? $model->software->email : $model->email;
                })
                ->editColumn('serial_key', function ($model) {
                    return $model->software->jenis_lisensi == 'software' ? $model->software->serial_key : $model->serial_key;
                })
                ->editColumn('expired', function ($model) {
                    $exp = $model->software->jenis_lisensi == 'software' ? $model->software->expired : $model->expired;
                    return date('d-m-Y', strtotime($exp));
                })
                ->addColumn('menu', function ($model) {
                    $exp = $model->software->jenis_lisensi == 'software' ? $model->software->expired : $model->expired;
                    $json = http_build_query([
                        'software_id'   => $model->software_id,
                        'jenis_lisensi' => $model->software->jenis_lisensi,
                        'tipe_langganan'=> $model->software->jenis_lisensi == 'software' ? $model->software->tipe_langganan : $model->tipe_langganan,
                        'expired'       => date('d-m-Y', strtotime($exp)),
                        'email'         => $model->software->jenis_lisensi == 'software' ? $model->software->email : $model->email,
                        'serial_key'    => $model->software->jenis_lisensi == 'software' ? $model->software->serial_key : $model->serial_key
                    ]);
                
                    $editlink = '';
                    if($model->software->jenis_lisensi == 'perangkat'){
                        $editlink = "<li><a class='dropdown-item edit-software' href='javascript:void(0)' data-id='$model->id' data-json='$json'>Edit</a></li>";
                    }

                    $edit = '<div class="btn-group">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        '.$editlink.'
                        <li><a class="dropdown-item delete-software" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                    </ul>
                    </div>';
                    return $edit;
                })
                ->rawColumns(['menu'])
                ->toJson();
    }

    public function storeSoftware(Request $request, FlasherInterface $flasher)
    {
        try {
            $validator = Validator::make($request->all(), [
                'software_id' => 'required',
            ])->validate();

            DB::beginTransaction();

            if (empty($request->pc_software_id)) {
                $data = new PcSoftware;
            } else {
                $data = PcSoftware::find($request->pc_software_id);
            }
            $soft = explode('#', $request->software_id);
            $data->no_inventaris = $request->no_inventaris;
            $data->software_id = $soft[0];
            if($soft[1] == 'perangkat'){
                $data->jenis_lisensi = $request->jenis_lisensi;
                $data->tipe_langganan = $request->tipe_langganan;
                $data->expired = date('Y-m-d', strtotime($request->expired));
                $data->email = $request->email;
                $data->serial_key = $request->serial_key;
            }
            $data->save();

            DB::commit();
        } catch(Exception $e) {
            DB::rollback();
        }
    }

    public function destroySoftware(Request $request)
    {
        DB::beginTransaction();

        try {               
            $data = PcSoftware::find($request->id)->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

    public function qrcode()
    {
        $pat = Pat::select('ket', DB::raw("concat( concat( kd_pat, '#' ), ket ) as kdket"));
        if (session('TMP_KDWIL') != "0A") {
            $pat->where("kd_pat", session('TMP_KDWIL'));
        }
        $pat = $pat->get()->pluck('ket', 'kdket')->toArray();
        $labelPat = ["" => "- Pilih PAT -"];
        $pat = $labelPat + $pat;

        return view('pages.inventaris-it.qrcode', [
            'pat' => $pat
        ]);
    }

    public function qrcodePdf(Request $request)
    {
        $pat = !empty($request->kd_pat)?$request->kd_pat:"";
        $ket = "";

        $query = Pc::with(['pat']);

        if (!empty($pat)) {
            $tmp = explode("#", $pat);
            $pat = $tmp[0];
            $ket = $tmp[1];

            $query->where('kd_pat', $pat);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('pages.inventaris-it.qrcode-pdf', [
            'data' => $data,
            'ket' => $ket
        ]);

        $filename = "Inventaris-IT-";
        $filename .= !empty($ket)?$ket:"QrCode-list";

        return $pdf->setPaper('a4', 'portrait')
            ->stream($filename . '.pdf');
    }



    public function report()
    {
        $pat = Pat::all()->pluck('ket', 'kd_pat')->toArray();
        $labelPat = ["" => "- Pilih PAT/PPU -"];
        $pat = $labelPat + $pat;

        $tipepc = TipePc::all()->pluck('ket', 'kd_tipe_pc')->toArray();
        $labelTipepc = ["" => "- Pilih Tipe Perangkat -"];
        $tipepc = $labelTipepc + $tipepc;

        return view('pages.inventaris-it.report', [
            'pat' => $pat,
            'tipepc' => $tipepc,
        ]);
    }

    public function reportExport(Request $request, FlasherInterface $flasher)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kd_pat' => 'required',
                'kd_tipe_pc' => 'required',
            ])->validate();

            $data = Pc::with('pc_softwares');
            $pat = Pat::find($request->kd_pat);

            if (!empty($request->kd_pat)) {
                $data->where('kd_pat', $request->kd_pat);
            }

            if (!empty($request->kd_tipe_pc)) {
                $data->where('kd_tipe_pc', $request->kd_tipe_pc);
            }

            $data = $data->get();

            return Pdf::loadView('pages.inventaris-it.report-pdf', [
                    'inventories' => $data,
                    'pat' => $pat
                ])
                ->setPaper('a4', 'landscape')
                ->download('Inventaris IT.pdf');

        } catch(Exception $e) {
            $flasher->addError('An error has occurred please try again later.');
        }
    }
}
