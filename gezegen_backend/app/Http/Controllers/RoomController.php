<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('hotel');

        if ($request->has('hotel_id')) {
            $query->where('hotel_id', $request->hotel_id);
        }

        if ($request->has('price_start')) {
            $query->where('price_per_night', '>=', $request->price_start);
        }

        if ($request->has('price_end')) {
            $query->where('price_per_night', '<=', $request->price_end);
        }

        if ($request->has('is_available')) {
            $query->where('is_available', filter_var($request->is_available, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->has('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        return RoomResource::collection($query->get());
    }

    public function show(Room $room)
    {
        return new RoomResource($room->load('hotel'));
    }

    public function byHotel(Hotel $hotel)
    {
        $rooms = $hotel->rooms()->with('hotel')->get();
        return RoomResource::collection($rooms);
    }
}
