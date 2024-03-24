<?php

use App\Models\Ruangan;
use App\Models\Jenis;
use App\Models\Pc;
use App\Models\TipePc;
use App\Models\Inventory;
use Illuminate\Support\Facades\Storage;

if (!function_exists('generateKodeInventaris')) {
    function generateKodeInventaris($parameters){
        $lantaiRuangan = sprintf("%02s", Ruangan::find($parameters->ruangan_id)->floor);
        $kodeJenis = sprintf("%02s", Jenis::find($parameters->jenis_id)->code);

        return $lantaiRuangan . '.' . 
            $parameters->kode_lokasi . '.' . 
            $kodeJenis . '.' . 
            $parameters->no_registrasi . '.' . 
            $parameters->tahun_perolehan;
    }
}

if (!function_exists('generateKodeInventarisKantor')) {
    function generateKodeInventarisKantor($parameters){

        $tahunPerolehan =  substr($parameters->tahun_perolehan, -2);
        $kodeJenis = sprintf("%03s", Jenis::find($parameters->jenis_id)->code);
        $maxNoRegistrasi = Inventory::whereNotNull('no_registrasi')->max('no_registrasi') ?? 0;
        $currentMasNoRegistrasi = sprintf("%04s",(intval($maxNoRegistrasi) + 1));

        return $tahunPerolehan .  $kodeJenis . $currentMasNoRegistrasi;
    }
}

function cekDir($dir, $disk = "local"){

    if (!Storage::disk($disk)->exists($dir)) {
        Storage::disk($disk)->makeDirectory($dir, 0777, true);
    }
}

if (!function_exists('generateNoInventarisIt')) {
    function generateNoInventarisIt($parameters){
        $xx = date("y", strtotime($parameters->tgl_perolehan));
        $yyy = str_pad(TipePc::find($parameters->kd_tipe_pc)->kode, 3, "x");
        $zzzz = sprintf("%04s", $parameters->no_registrasi);

        return $xx . $yyy . $zzzz;
    }
}
if (!function_exists('full_url_from_path')) {
    function full_url_from_path($path) {
        if($path == null){
            return null;
        }
        return route('api.file.viewer', ['path' => str_replace("/", "|", $path)]);;
    }
}