<?php

namespace Database\Seeders;

use App\Models\RevokedToken;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RevokedTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RevokedToken::factory()->create();
    }
}
