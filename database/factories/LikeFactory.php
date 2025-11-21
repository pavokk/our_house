<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class LikeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => 'heart',
            'user_id' => User::factory(),
        ];
    }
}
