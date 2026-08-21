<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
public function index()
{
    $titre = 'Tous les articles de DevBlog';

    $articles = [
        ['titre' => 'Débuter avec Laravel', 'auteur' => 'Alex'],
        ['titre' => 'Comprendre les routes', 'auteur' => 'Sam'],
        ['titre' => 'Blade pour les nuls', 'auteur' => 'Alex'],
    ];

    return view('articles.index', compact('titre', 'articles'));
}

    
}
