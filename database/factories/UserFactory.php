<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'name' => fake()->name($gender),
            'age' => fake()->numberBetween(18, 65),
            'gender' => $gender,
            // 'contact_number' => substr(fake()->phoneNumber(), 0, 12),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make(fake()->sentence()),
            'type' => 'tourist',
            'api_token' => \Illuminate\Support\Str::random(60),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
