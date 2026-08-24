<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $donneesValides = $request->validate([
            'titre'  => 'required|min:3|max:255',
            'contenu'  => 'required',
            'auteur'  => 'nullable|max:100',
        ]);

        Article::create($donneesValides);

        return redirect()->route('articles.index');
    }

    public function index()
    {
        $articles = Article::all();

        return view('articles.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);

        return view('articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, $id) {
        $donneesValidees = $request->validate([
            'titre' => 'required|min:3|max:255',
            'contenu' =>  'required',
            'auteur' =>  'nullable|max:100',
        ]);

        $article = Article::findOrFail(($id));
        $article->update($donneesValidees);

        return redirect()->route('articles.show', $article->id);
    }

    public function destroy($id) {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index');
    }
}
