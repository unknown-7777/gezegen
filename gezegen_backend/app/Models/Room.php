<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'hotel_id', 'room_number', 'capacity',
        'price_per_night', 'room_type',
        'is_available', 'description'
    ];

    const ROOM_TYPES = ['Deluxe', 'Suite', 'Standard'];

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }
}
