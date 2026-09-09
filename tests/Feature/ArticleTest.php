<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('permet à un utilisateur connecté de créer un article', function () {
    // Arrange : on prépare un utilisateur (grâce à la factory du Module 7)
    $user = User::factory()->create();

    // Act : connecté en tant que cet utilisateur, on envoie le formulaire
    $response = $this->actingAs($user)->post('/articles', [
        'titre' => 'Mon premier article de test',
        'contenu' => 'Du contenu écrit pour le test.',
    ]);

    // Assert : on vérifie le résultat
    $response->assertRedirect('/articles');
    $this->assertDatabaseHas('articles', [
        'titre' => 'Mon premier article de test',
    ]);
});

it('refuse de créer un article sans titre', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/articles', [
        'titre' => '', // titre vide : doit être refusé
        'contenu' => 'Du contenu valide.',
    ]);

    // La validation doit signaler une erreur sur le champ 'titre'
    $response->assertSessionHasErrors('titre');

    // ... et AUCUN article ne doit avoir été créé
    $this->assertDatabaseCount('articles', 0);
});

// Test A : un visiteur non connecté est renvoyé vers la connexion (protection Module 8)
it('redirige un visiteur non connecté loin du formulaire de création', function () {
    // Pas de actingAs : on est un invité
    $response = $this->get('/articles/create');

    $response->assertRedirect('/login');
});

// Test B : la page d'un article affiche son titre
it('affiche le titre d\'un article sur sa page', function () {
    $article = Article::factory()->create([
        'titre' => 'Un titre bien visible',
    ]);

    $response = $this->get('/articles/'.$article->id);

    $response->assertStatus(200);
    $response->assertSee('Un titre bien visible');
});

it('attache les catégories et tags choisis à la création', function () {
    $user = User::factory()->create();
    $cats = Category::factory()->count(2)->create();
    $tags = Tag::factory()->count(2)->create();

    $this->actingAs($user)->post('/articles', [
        'titre' => 'Article catégorisé',
        'contenu' => 'du contenu',
        'categories' => $cats->pluck('id')->all(),
        'tags' => [$tags->first()->id],
    ])->assertRedirect('/articles');

    $article = Article::firstWhere('titre', 'Article catégorisé');
    expect($article->categories)->toHaveCount(2);
    expect($article->tags)->toHaveCount(1);
});

it('interdit de modifier ou supprimer l’article d’un autre (web)', function () {
    $article = Article::factory()->create();
    $intrus = User::factory()->create();

    $this->actingAs($intrus)->get(route('articles.edit', $article->id))->assertForbidden();
    $this->actingAs($intrus)->put(route('articles.update', $article->id), [
        'titre' => 'Titre pirate', 'contenu' => 'nope',
    ])->assertForbidden();
    $this->actingAs($intrus)->delete(route('articles.destroy', $article->id))->assertForbidden();

    $this->assertDatabaseHas('articles', ['id' => $article->id]);
});

it('laisse le propriétaire modifier son article', function () {
    $user = User::factory()->create();
    $article = Article::factory()->for($user)->create();

    $this->actingAs($user)->put(route('articles.update', $article->id), [
        'titre' => 'Titre mis à jour',
        'contenu' => 'contenu mis à jour',
    ])->assertRedirect(route('articles.show', $article->id));

    $this->assertDatabaseHas('articles', ['id' => $article->id, 'titre' => 'Titre mis à jour']);
});
