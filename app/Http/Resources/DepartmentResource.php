<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "mall_id" => $this->mall_id,
            "name" => $this->name,
            "address" => $this->address,
            "note" => $this->note,
            "malls" => new MallResource($this->whenLoaded('malls')),
            "Vendors" =>  MallResource::collection($this->whenLoaded('vendors'))
        ];
    }
}
