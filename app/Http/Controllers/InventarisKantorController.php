<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Merk;
use App\Models\Ruangan;
use App\Models\Jenis;
use App\Models\Pat;
use Yajra\DataTables\Facades\DataTables;
use Flasher\Prime\FlasherInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\InventarisKantorExport;
use App\Models\InventoryName;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class InventarisKantorController extends Controller
{
    public function index(){
        return view('pages.inventaris-kantor.index');
    }

    public function data()
    {
        $query = Inventory::with(['ruangan', 'jenis'])->select('*');
        if (session('TMP_KDWIL') != "0A") {
            $query->where("kode_lokasi", session('TMP_KDWIL'));
        }
            
        return DataTables::eloquent($query)
                ->addColumn('menu', function ($model) {
                    $edit = '<div class="btn-group">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . route('inventaris-kantor.edit', $model->id) . '">Edit</a></li>
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
        $merk = Merk::pluck('ket', 'ket');
        $ruangan = Ruangan::pluck('name', 'id');
        $jenis = Jenis::pluck('name', 'id');
        $pat = Pat::pluck('ket', 'kd_pat');
        $nama = InventoryName::pluck('nama', 'nama');
        
        return view('pages.inventaris-kantor.create', compact(
            'merk', 'ruangan', 'jenis', 'pat', 'nama'
        ));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
            Validator::make($request->all(), [
                'nama'              => 'required',
                'tahun_perolehan'   => 'required',
                'ruangan_id'        => 'required',
                'jenis_id'          => 'required',
                'kode_lokasi'       => 'required',
            ])->validate();


            $no_inventaris = generateKodeInventarisKantor($request);
            $maxNoRegistrasi = Inventory::whereNotNull('no_registrasi')->max('no_registrasi') ?? 0;

            $data                   = new Inventory();
            $data->kode             = $no_inventaris;
            $data->no_registrasi    = intval($maxNoRegistrasi) + 1;
            $data->nama             = $request->nama;
            $data->merk             = $request->merk;
            $data->tipe             = $request->tipe;
            $data->spek             = $request->spek;
            $data->tahun_perolehan  = $request->tahun_perolehan;
            $data->ruangan_id       = $request->ruangan_id;
            $data->jenis_id         = $request->jenis_id;
            $data->kode_lokasi      = $request->kode_lokasi;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data telah berhasil dibuat!');
        } catch(Exception $e) {
            DB::rollback();
            
            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('inventaris-kantor.index');
    }

    public function edit($id)
    {
        $data = Inventory::find($id);
        $merk = Merk::pluck('ket', 'ket');
        $ruangan = Ruangan::pluck('name', 'id');
        $jenis = Jenis::pluck('name', 'id');
        $pat = Pat::pluck('ket', 'kd_pat');
        $nama = InventoryName::pluck('nama', 'nama');

        return view('pages.inventaris-kantor.create', compact(
            'data', 'merk', 'ruangan', 'jenis', 'pat', 'nama'
        ));   
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        DB::beginTransaction();

        try {
        	Validator::make($request->all(), [
                'nama'              => 'required',
                'tahun_perolehan'   => 'required',
                'ruangan_id'        => 'required',
                'jenis_id'          => 'required',
                'kode_lokasi'       => 'required',
            ])->validate();

            $data = Inventory::find($id);
            $data->nama             = $request->nama;
            $data->merk             = $request->merk;
            $data->tipe             = $request->tipe;
            $data->spek             = $request->spek;
            $data->tahun_perolehan  = $request->tahun_perolehan;
            $data->ruangan_id       = $request->ruangan_id;
            $data->jenis_id         = $request->jenis_id;
            $data->kode_lokasi      = $request->kode_lokasi;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data telah berhasil diperbarui!');
        } catch(Exception $e) {
            DB::rollback();

            $flasher->addError('Terjadi error silahkan coba beberapa saat lagi.');
        }

        return redirect()->route('inventaris-kantor.index');
    }
    
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {               
            $data = Inventory::find($request->id);

            $data->delete();

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
        $labelPat = ["" => "- Pilih Lokasi -"];
        $pat = $labelPat + $pat;

        return view('pages.inventaris-kantor.qrcode', [
            'pat' => $pat
        ]);
    }

    public function qrcodePdf(Request $request)
    {
        $pat = !empty($request->kd_pat)?$request->kd_pat:"";
        $ket = "";

        $query = Inventory::with(['lokasi']);

        if (!empty($pat)) {
            $tmp = explode("#", $pat);
            $pat = $tmp[0];
            $ket = $tmp[1];

            $query->where('kode_lokasi', $pat);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('pages.inventaris-kantor.qrcode-pdf', [
            'data' => $data,
            'ket' => $ket
        ]);

        $filename = "Inventaris-Kantor-";
        $filename .= !empty($ket)?$ket:"QrCode-list";

        return $pdf->setPaper('a4', 'portrait')
            ->stream($filename . '.pdf');
    }

    public function report()
    {
        return view('pages.inventaris-kantor.report');
    }

    public function reportExport(Request $request)
    {
        return $request->format == 'excel' 
            ? Excel::download(new InventarisKantorExport, 'Inventaris Kantor.xlsx')
            : Pdf::loadView('pages.inventaris-kantor.report-pdf', ['inventories' => Inventory::with('pat')->get()])->download('Inventaris Kantor.pdf');
    }
}
