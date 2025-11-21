<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'comment' => fake()->paragraph(2),
            'user_id' => User::factory(),
            'parent_id' => null,
        ];
    }
}
