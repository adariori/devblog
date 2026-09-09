<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = Category::factory()->count(6)->create();
        $tags = Tag::factory()->count(8)->create();

        Article::factory()->count(30)->create()->each(function (Article $article) use ($categories, $tags) {
            $article->categories()->attach($categories->random(rand(1, 3))->pluck('id')->all());
            $article->tags()->attach($tags->random(rand(1, 3))->pluck('id')->all());
        });
    }
}
