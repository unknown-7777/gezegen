<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'room_number' => fake()->bothify('##?'),
            'capacity' => fake()->numberBetween(1, 4),
            'price_per_night' => fake()->randomFloat(2, 30, 500),
            'room_type' => fake()->randomElement(['Deluxe', 'Suite', 'Standard']),
            'is_available' => true,
            'description' => fake()->sentence(),
        ];
    }
}
