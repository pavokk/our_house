<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['heart', 'thumb-up', 'laugh']),
        ];
    }
}
