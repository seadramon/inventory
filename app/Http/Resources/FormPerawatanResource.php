<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormPerawatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $disabled = false;
        $message = '';

        $assign = $this->latest_assign;
        $now = strtotime(now());
        if(strtotime($assign->periode_awal) <= $now && strtotime(str_replace('00:00:00', '23:59:59', $assign->periode_akhir)) >= $now){
            $disabled = false;
        }else{
            $disabled = true;
            $message = 'Sudah Melewati Periode ' . date('d-m-Y', strtotime($assign->periode_awal)) . '-' . date('d-m-Y', strtotime($assign->periode_akhir));
        }
        if($assign->perawatan != null){
            $disabled = true;
            $message = 'Perawatan Sudah Dilakukan ';
        }
        return [
            "id" => $this->id,
            "nama" => $this->nama,
            "disabled" => $disabled,
            "message" => $message,
            "details" => FormPerawatanDetailResource::collection($this->detail),
            "latest_perawatan" => new PerawatanResource($assign->perawatan)
        ];
    }
}
