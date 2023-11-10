<?php

namespace Database\Seeders;

use App\Models\Tourist\AvailableReservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailableReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kubo
        for($i = 0; $i < 4; $i++) {
            AvailableReservation::create([
                'id' => $i + 1,
                'type' => 'kubo',
                'price_per_head' => 350,
                'children_discount' => 0.10,
                'name_of_spot' => "Kubo " . $i + 1,
                'size_of_spot' => 'medium',
                'description' => 'Good for 5-15 person.\nLocated at beside Polerio Dam the River',
                'photo' => 'http://localhost:8000/assets/images/presets/preset-3.jpg',
                'status' => 'available'
            ]);
        }

        // Cottage
        for($i = 0; $i < 4; $i++) {
            AvailableReservation::create([
                'type' => 'cottage',
                'price_per_head' => 250,
                'children_discount' => 0.10,
                'name_of_spot' => "Cottage " . $i + 1,
                'size_of_spot' => 'small',
                'description' => 'Good for 3-6 person.\nLocated at beside the campsite',
                'photo' => 'http://localhost:8000/assets/images/presets/preset-3.jpg',
                'status' => 'available'
            ]);
        }
    }
}
