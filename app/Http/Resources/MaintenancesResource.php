<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaintenancesResource extends JsonResource
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
            "id"               => $this->id,
            "no_inventaris"    => $this->no_inventaris,
            "no_tiket"         => $this->no_tiket,
            "permasalahan"     => $this->permasalahan,
            "diagnosa"         => $this->diagnosa,
            "tindak_lanjut"    => $this->tindak_lanjut,
            "jenis_penanganan" => $this->jenis_penanganan,
            "hasil"            => $this->hasil,
            "foto"             => $this->foto_path ? route('api.file.viewer', ['path' => str_replace('/', '|', $this->foto_path)]) : null,
            "created_at"       => $this->created_at
        ];
    }
}
