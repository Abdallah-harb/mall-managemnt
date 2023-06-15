<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MallResource extends JsonResource
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
            "manager" => $this->manager_id,
            "name" => $this->name,
            "address" => $this->address,
            "phone"=>$this->phone,
            "space"=>$this->space,
            "note"=>$this->phone,
            "photo"=>asset($this->photo)
        ];
    }
}
