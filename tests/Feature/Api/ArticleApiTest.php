<?php

use App\Models\Article;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('délivre un jeton avec de bons identifiants', function () {
    User::factory()->create(['email' => 'api@devblog.test']); // mot de passe factory = "password"

    $this->postJson('/api/login', [
        'email' => 'api@devblog.test',
        'password' => 'password',
    ])->assertOk()->assertJsonStructure(['token']);
});

it('refuse un jeton avec de mauvais identifiants', function () {
    User::factory()->create(['email' => 'api@devblog.test']);

    $this->postJson('/api/login', [
        'email' => 'api@devblog.test',
        'password' => 'faux',
    ])->assertStatus(401);
});

it('expose la liste des articles publiquement', function () {
    Article::factory()->count(3)->create();

    $this->getJson('/api/articles')
        ->assertOk()
        ->assertJsonCount(3, 'data');
});

it('refuse la création sans jeton', function () {
    $this->postJson('/api/articles', ['titre' => 'Titre test', 'contenu' => 'du contenu'])
        ->assertStatus(401);
});

it('crée un article lié au porteur du jeton', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->postJson('/api/articles', ['titre' => 'Mon article API', 'contenu' => 'contenu via API'])
        ->assertCreated();

    $this->assertDatabaseHas('articles', [
        'titre' => 'Mon article API',
        'user_id' => $user->id,
    ]);
});

it('interdit de modifier l’article d’un autre utilisateur', function () {
    $article = Article::factory()->create(); // appartient à un autre user
    Sanctum::actingAs(User::factory()->create());

    $this->putJson("/api/articles/{$article->id}", ['titre' => 'Titre pirate'])
        ->assertForbidden();
});

it('interdit de supprimer l’article d’un autre utilisateur', function () {
    $article = Article::factory()->create();
    Sanctum::actingAs(User::factory()->create());

    $this->deleteJson("/api/articles/{$article->id}")->assertForbidden();
});

it('autorise le propriétaire à modifier son article', function () {
    $user = User::factory()->create();
    $article = Article::factory()->for($user)->create();
    Sanctum::actingAs($user);

    $this->putJson("/api/articles/{$article->id}", ['titre' => 'Titre corrigé'])
        ->assertOk();

    $this->assertDatabaseHas('articles', ['id' => $article->id, 'titre' => 'Titre corrigé']);
});
