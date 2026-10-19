<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'city_id'     => 'required|exists:cities,id',
            'name'        => 'required|string|max:255|unique:hotels,name',
            'slug'        => 'required|string|unique:hotels,slug',
            'address'     => 'required|string',
            'capacity'    => 'required|integer|min:1',
            'phone'       => 'required|string',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'active'      => 'boolean',
        ];
    }
}
