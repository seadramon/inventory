<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PerawatanDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "nama" => $this->nama,
            "value" => $this->value,
            "keterangan" => $this->keterangan,
            "foto" =>  $this->foto == null ? null : route('api.file.viewer', ['path' => str_replace('/', '|', $this->foto)])
        ];
    }
}
