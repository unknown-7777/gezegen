<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Http\Resources\HotelResource;
use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\HotelUpdateRequest;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('city', 'rooms')->get();
        return HotelResource::collection($hotels);
    }

    public function show(Hotel $hotel)
    {
        return new HotelResource($hotel->load('city', 'rooms'));
    }

    public function store(HotelStoreRequest $request)
    {
        $hotel = Hotel::create($request->validated());
        return new HotelResource($hotel->load('city', 'rooms'));
    }

    public function update(HotelUpdateRequest $request, Hotel $hotel)
    {
        $hotel->update($request->validated());
        return new HotelResource($hotel->load('city', 'rooms'));
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response()->json(['message' => 'Hotel deleted successfully'], 204);
    }
}
