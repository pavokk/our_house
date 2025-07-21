<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->name();
        return [
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'), // default password for all test users
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'type' => 'guest',
            'remember_token' => Str::random(10),
        ];
    }
}
