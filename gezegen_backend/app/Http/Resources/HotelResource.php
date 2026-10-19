<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'address'     => $this->address,
            'phone'       => $this->phone,
            'rating'      => $this->rating,
            'capacity'    => $this->capacity,
            'description' => $this->description,
            'image'       => $this->image,
            'active'      => $this->active,
            'city'        => [
                'id'   => $this->city->id,
                'name' => $this->city->name,
            ],
            'rooms_count' => $this->rooms->count(),
        ];
    }
}
