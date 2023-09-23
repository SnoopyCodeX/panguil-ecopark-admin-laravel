<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $hasDefaultAdmin = \App\Models\User::where('type', 'admin')->first();

        // If there's no default admin, create one
        if(!$hasDefaultAdmin) {
            \App\Models\User::factory()->createOne([
                'name' => 'Tatel Admin',
                'age' => 25,
                'gender' => 'female',
                'email' => 'tatel@gmail.com',
                'password' => Hash::make('test123'),
                'type' => 'admin',
            ]);
        }

        $this->call([
            ReminderSeeder::class,
            ReservationSeeder::class,
            TouristSeeder::class,
            TouristsToGuideSeeder::class,
        ]);
    }
}
