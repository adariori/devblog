<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(),
            'contenu' => fake()->paragraphs(3, true),
            'user_id' => User::factory(),
        ];
    }
}