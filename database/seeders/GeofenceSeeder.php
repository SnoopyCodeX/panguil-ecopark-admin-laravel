<?php

namespace Database\Seeders;

use App\Models\Geofence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeofenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Geofence::factory(5)->create();
    }
}
