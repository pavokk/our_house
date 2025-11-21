<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Image;
use App\Models\User;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->company() . ' Annual Meetup';
        $start = fake()->dateTimeBetween('+1 week', '+2 weeks');

        return [
            'title' => $name,
            'slug' => Str::slug($name),
            'content' => fake()->paragraph(),
            'start' => $start,
            'end' => fake()->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +8 hours'),
            'image_id' => Image::factory(),
            'user_id' => User::factory(),
        ];
    }
}
