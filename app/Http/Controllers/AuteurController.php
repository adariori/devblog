<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuteurController extends Controller
{
    /**
     * Liste des utilisateurs qui ont publié au moins un article.
     */
    public function index()
    {
        $auteurs = User::has('articles')
            ->withCount('articles')
            ->orderBy('name')
            ->get();

        return view('auteurs.index', compact('auteurs'));
    }

    /**
     * Un auteur et ses articles.
     */
    public function show($id)
    {
        $auteur = User::withCount('articles')->findOrFail($id);
        $articles = $auteur->articles()->with('categories')->latest()->get();

        return view('auteurs.show', compact('auteur', 'articles'));
    }
}
