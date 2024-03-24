<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormPerawatanDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $pilihan = explode("|", $this->pilihan);

        return [
            "id" => $this->id,
            "nama" => $this->nama,
            "parameter" => $this->parameter,
            "jenis" => $this->jenis,
            "pilihan" => $pilihan,
            "foto_needed" => $this->foto_needed,
            "keterangan_needed" => $this->keterangan_needed,
        ];
    }
}
