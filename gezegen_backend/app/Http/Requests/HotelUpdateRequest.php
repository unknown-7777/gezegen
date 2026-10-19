<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $hotelId = $this->route('hotel')->id;

        return [
            'city_id'     => 'sometimes|exists:cities,id',
            'name'        => 'sometimes|string|max:255|unique:hotels,name,' . $hotelId,
            'slug'        => 'sometimes|string|unique:hotels,slug,' . $hotelId,
            'address'     => 'sometimes|string',
            'capacity'    => 'sometimes|integer|min:1',
            'phone'       => 'sometimes|string',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'active'      => 'boolean',
        ];
    }
}
