<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    /** @use HasFactory<\Database\Factories\HotelFactory> */
    use HasFactory;

    protected $fillable = [
        'city_id', 'name', 'slug', 'address',
        'capacity', 'phone', 'rating',
        'description', 'image', 'active'
    ];

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function rooms() {
        return $this->hasMany(Room::class);
    }
}
