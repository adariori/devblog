<?php

use App\Models\User;

it('refuse la zone admin à un visiteur', function () {
    $this->get('/admin/tableau-de-bord')->assertForbidden();
});

it('refuse la zone admin à un utilisateur normal', function () {
    $this->actingAs(User::factory()->create())
        ->get('/admin/tableau-de-bord')
        ->assertForbidden();
});

it('autorise la zone admin à l’administrateur', function () {
    $admin = User::factory()->create(['email' => 'admin@devblog.test']);

    $this->actingAs($admin)->get('/admin/tableau-de-bord')->assertOk();
});
