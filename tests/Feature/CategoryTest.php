<?php

use App\Models\Category;
use App\Models\User;

it('réserve la gestion des catégories aux utilisateurs connectés', function () {
    $this->get('/categories')->assertRedirect('/login');
    $this->post('/categories', ['nom' => 'Test'])->assertRedirect('/login');
});

it('permet à un utilisateur connecté de créer une catégorie', function () {
    $this->actingAs(User::factory()->create())
        ->post('/categories', ['nom' => 'Laravel'])
        ->assertRedirect(route('categories.index'));

    $this->assertDatabaseHas('categories', ['nom' => 'Laravel']);
});

it('refuse une catégorie sans nom ou en doublon', function () {
    $user = User::factory()->create();
    Category::factory()->create(['nom' => 'Doublon']);

    $this->actingAs($user)->post('/categories', ['nom' => ''])->assertSessionHasErrors('nom');
    $this->actingAs($user)->post('/categories', ['nom' => 'Doublon'])->assertSessionHasErrors('nom');

    $this->assertDatabaseCount('categories', 1);
});

it('permet de modifier et supprimer une catégorie', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['nom' => 'Ancien']);

    $this->actingAs($user)->put(route('categories.update', $category), ['nom' => 'Nouveau'])
        ->assertRedirect(route('categories.index'));
    $this->assertDatabaseHas('categories', ['id' => $category->id, 'nom' => 'Nouveau']);

    $this->actingAs($user)->delete(route('categories.destroy', $category))
        ->assertRedirect(route('categories.index'));
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});
