<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->realText(50);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'image' => fake()->imageUrl,
            'content' => fake()->realText(5000),
            'status' => collect(fake()->randomElements(['published', 'draft', 'reviewing'], 1))->implode(''),
            'user_id' => fake()->numberBetween(2, 4),
        ];
    }
}
