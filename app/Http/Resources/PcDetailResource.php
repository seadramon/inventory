<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PcDetailResource extends JsonResource
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
            "item" => [
                "kode" => $this->item->kd_item ?? '',
                "nama" => $this->item->ket ?? ''
            ],
            "merk" => [
                "kode" => $this->merk->kd_merk,
                "nama" => $this->merk->ket
            ],
            "spesifikasi"=> $this->spesifikasi,
            "tipe"=> $this->tipe,
            "kapasitas"=> $this->kapasitas,
            "satuan"=> $this->satuan,
            "created_at"=> $this->created_date
        ];
    }
}
