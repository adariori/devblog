<?php

use App\Models\Article;
use App\Models\User;

it('liste les auteurs ayant publié', function () {
    $withArticles = User::factory()->create(['name' => 'Alice']);
    Article::factory()->for($withArticles)->create();
    User::factory()->create(['name' => 'Bob']); // sans article

    $this->get(route('auteurs.index'))
        ->assertOk()
        ->assertSee('Alice')
        ->assertDontSee('Bob');
});

it('affiche la page d’un auteur et ses articles', function () {
    $user = User::factory()->create(['name' => 'Charlie']);
    Article::factory()->for($user)->create(['titre' => 'Article de Charlie']);

    $this->get(route('auteurs.show', $user->id))
        ->assertOk()
        ->assertSee('Charlie')
        ->assertSee('Article de Charlie');
});
