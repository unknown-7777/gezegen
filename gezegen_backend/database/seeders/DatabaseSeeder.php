<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        City::factory(5)
            ->has(
                Hotel::factory(3)
                    ->has(Room::factory(5), 'rooms'),
                'hotels'
            )
            ->create();
    }
}
