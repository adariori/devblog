<?php

use App\Models\Article;
use App\Models\User;

it('permet à un visiteur de laisser un commentaire', function () {
    $article = Article::factory()->create();

    $this->post(route('comments.store', $article->id), [
        'auteur' => 'Visiteur',
        'contenu' => 'Très bon article !',
    ])->assertRedirect(route('articles.show', $article->id));

    $this->assertDatabaseHas('comments', [
        'article_id' => $article->id,
        'auteur' => 'Visiteur',
    ]);
});

it('valide le commentaire', function () {
    $article = Article::factory()->create();

    $this->post(route('comments.store', $article->id), ['auteur' => '', 'contenu' => 'x'])
        ->assertSessionHasErrors(['auteur', 'contenu']);

    $this->assertDatabaseCount('comments', 0);
});

it('laisse un modérateur supprimer un commentaire', function () {
    $article = Article::factory()->create();
    $comment = $article->comments()->create(['auteur' => 'X', 'contenu' => 'à supprimer']);
    $moderateur = User::factory()->create(['is_moderator' => true]);

    $this->actingAs($moderateur)->delete(route('comments.destroy', $comment->id))->assertRedirect();

    $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
});

it('interdit à un non-modérateur de supprimer un commentaire', function () {
    $article = Article::factory()->create();
    $comment = $article->comments()->create(['auteur' => 'X', 'contenu' => 'reste']);

    $this->actingAs(User::factory()->create())
        ->delete(route('comments.destroy', $comment->id))
        ->assertForbidden();

    $this->assertDatabaseHas('comments', ['id' => $comment->id]);
});

it('exige une connexion pour supprimer un commentaire', function () {
    $article = Article::factory()->create();
    $comment = $article->comments()->create(['auteur' => 'X', 'contenu' => 'reste']);

    $this->delete(route('comments.destroy', $comment->id))->assertRedirect('/login');
});
