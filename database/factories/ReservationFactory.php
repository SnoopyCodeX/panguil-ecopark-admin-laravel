<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = ['male', 'female'];

        return [
            'name' => fake()->name(),
            'gender' => fake()->randomElement($genders),
            'age' => fake()->numberBetween(18, 65),
            'contact_number' => substr(fake()->phoneNumber(), 0, 12),
            'number_of_tourists' => fake()->randomNumber(),
            'assigned_tour_guide' => fake()->name()
        ];
    }
}
