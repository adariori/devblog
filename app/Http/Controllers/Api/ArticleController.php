<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Article::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $donnees = $request->validate([
            'titre' => 'required|min:3|max:255',
            'contenu' => 'required',
        ]);

        // La colonne user_id est obligatoire : on prend l'utilisateur du token
        // s'il y en a un, sinon le premier utilisateur (route publique pour ce test).
        $donnees['user_id'] = $request->user()?->id ?? User::first()?->id;

        $article = Article::create($donnees);

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Article::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        $donnees = $request->validate([
            'titre' => 'sometimes|required|min:3|max:255',
            'contenu' => 'sometimes|required',
        ]);

        $article->update($donnees);

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Article::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
