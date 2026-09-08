<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    //

    public function create()
    {
        return view('articles.create');
    }

    public function store(StoreArticleRequest $request)
    {

        $data = $request->validated();

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        unset($data['cover']);

        $request->user()->articles()->create($data);

        return redirect()->route('articles.index');
    }

    public function index()
    {
        $articles = Article::all();

        return ArticleResource::collection(Article::all());
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);

        return new ArticleResource(Article::findOrFail($id));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        Gate::authorize('update', $article); // 🚫 403 si ce n'est pas son article

        return view('articles.edit', compact('article'));
    }

    public function update(UpdateArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        Gate::authorize('update', $article); // sécurité du Module 9 !

        $data = $request->validated();

        if ($request->hasFile('cover')) {
            // 1. Supprimer l'ancienne image si elle existe
            if ($article->cover_path) {
                Storage::disk('public')->delete($article->cover_path);
            }
            // 2. Stocker la nouvelle
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        unset($data['cover']);
        $article->update($data);

        return redirect()->route('articles.show', $article->id);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        Gate::authorize('delete', $article);

        if ($article->cover_path) {
            Storage::disk('public')->delete($article->cover_path);
        }

        $article->delete();

        return redirect()->route('articles.index');
    }
}
