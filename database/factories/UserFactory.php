<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Image; // Import Image

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'slug' => fn (array $attributes) => Str::slug($attributes['name']),
            'image_id' => Image::factory(), // <-- Creates a new image for this user
            'description' => fake()->paragraph(),
            'type' => 'guest',
            'remember_token' => Str::random(10),
        ];
    }
}
