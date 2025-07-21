<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'image' => 'https://via.placeholder.com/800x600.png',
            'type' => fake()->randomElement(['profile', 'post', 'event_banner']),
            'alt' => fake()->sentence(3),
        ];
    }
}
