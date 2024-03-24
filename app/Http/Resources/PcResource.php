<?php

namespace App\Http\Resources;

use App\Models\IkDocument;
use Illuminate\Http\Resources\Json\JsonResource;

class PcResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $menus = ["maintenance"];
        if($this->maintenances->count() > 0){
            $menus[] = "history_maintenance";
        }
        return [
            "kode_inventaris"=> $this->no_inventaris,
            "tipe_pc"=> $this->tipe_pc->ket ?? '',
            "pengguna"=> $this->pengguna,
            "nama"=> $this->pc_name,
            "model"=> $this->model,
            "workgroup"=> $this->workgroup,
            "domain"=> $this->domain,
            "ip_address"=> $this->ip4_address,
            "mac_address"=> $this->mac_address,
            "harga_perolehan"=> $this->hrg_perolehan,
            "tgl_perolehan"=> $this->tgl_perolehan,
            "nilai_buku"=> $this->nilai_buku,
            "status" => $this->status,
            "merk" => [
                "kode" => $this->merk->kd_merk,
                "nama" => $this->merk->ket
            ],
            "lokasi" => [
                "kode" => $this->pat->kd_pat,
                "nama" => $this->pat->ket
            ],
            "biro" => [
                "kode" => $this->gas->kd_gas,
                "nama" => $this->gas->ket
            ],
            "created_at" => $this->created_date,
            "menus" => $menus,
            "setting" => [
                "maintenance" => [
                    "service_rutin",
                    "upgrade",
                    "perbaikan_hardware",
                    "perbaikan_software",
                ]
            ],
            "detail" => PcDetailResource::collection($this->detail),
            "softwares" => PcSoftwareResource::collection($this->pc_softwares),
            "maintenances" => MaintenancesResource::collection($this->maintenances),
            "ik_document" => IkDocument::first()->file_url
        ];
    }
}
