<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'name' => fake()->company(),
            'slug' => fake()->slug(2),
            'address' => fake()->streetAddress(),
            'capacity' => fake()->numberBetween(20, 300),
            'phone' => fake()->phoneNumber(),
            'rating' => fake()->randomFloat(1, 1, 5),
            'description' => fake()->paragraph(),
            'image' => null,
            'active' => true,
        ];
    }
}
