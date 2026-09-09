<?php

it('redirige la racine vers la liste des articles', function () {
    $this->get('/')->assertRedirect(route('articles.index'));
});
