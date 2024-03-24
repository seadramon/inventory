<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PerawatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $presonal = $this->personal;
        return [
            "created_by" => $presonal->pengguna,
            "created_at" => date('d-m-Y', strtotime($this->created_at)),
            "detail" => PerawatanDetailResource::collection($this->detail)
        ];
    }
}
