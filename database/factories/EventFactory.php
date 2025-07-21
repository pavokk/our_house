<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('+1 week', '+3 week');
        $end = fake()->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +8 hours');

        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(2),
            'start' => $start,
            'end' => $end,
        ];
    }
}
