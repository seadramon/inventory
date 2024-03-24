<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id"=> $this->id,
            "kode_inventaris"=> $this->kode,
            "no_registrasi"=> $this->no_registrasi,
            "nama"=> $this->nama,
            "merk"=> $this->merk,
            "tipe"=> $this->tipe,
            "spek"=> $this->spek,
            "tahun_perolehan"=> $this->tahun_perolehan,
            "ruangan" => [
                "id"=> $this->ruangan->id,
                "nama"=> $this->ruangan->name,
                "lantai"=> $this->ruangan->floor
            ],
            "jenis" => [
                "kode"=> $this->jenis->code,
                "nama"=> $this->jenis->name
            ],
            "lokasi" => [
                "kode"=> $this->lokasi->kd_pat,
                "nama"=> $this->lokasi->ket
            ],
            "created_at"=> $this->created_at,
            "menus" => [
                "checklist_kontrol"
            ]
        ];
    }
}
