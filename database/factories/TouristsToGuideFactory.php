<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TouristsToGuide>
 */
class TouristsToGuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);

        return [
            'tour_guide_name' => fake()->name($gender),
            'assigned_datetime' => fake()->dateTime(),
            'tourist_name' => fake()->name($gender),
            'age' => fake()->numberBetween(18, 65),
            'gender' => $gender,
            'contact_number' => substr(fake()->phoneNumber(), 0, 12),
        ];
    }
}
