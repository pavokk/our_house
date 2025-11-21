<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Enums\TaskStatus;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraph(),
            'type' => 'general',
            'status' => fake()->randomElement(['todo', 'in_progress', 'done']),
            'due_date' => fake()->dateTimeBetween('+1 day', '+1 month'),
            'user_id' => User::factory(), // The creator
            'assignee_id' => null,
            'image_id' => null, // Tasks probably don't need images by default
        ];
    }
}
