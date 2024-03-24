<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PcSoftwareResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $software = $this->software;
        return [
            "nama"=> $software->nama,
            "jenis_lisensi"=> $software->jenis_lisensi,
            "tipe_langganan"=> $software->jenis_lisensi == 'perangkat' ? $this->tipe_langganan : $software->tipe_langganan,
            "email"=> $software->jenis_lisensi == 'perangkat' ? $this->email : $software->email,
            "serial_key"=> $software->jenis_lisensi == 'perangkat' ? $this->serial_key : $software->serial_key,
            "expired"=> $software->jenis_lisensi == 'perangkat' ? date('d-m-Y', strtotime($this->expired)) : date('d-m-Y', strtotime($software->expired))
        ];
    }
}
