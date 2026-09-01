<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    //

    public function create()
    {
        return view('articles.create');
    }

    public function store(StoreArticleRequest $request)
    {
        $request->user()->articles()->create($request->validated());

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
    Gate::authorize('update', $article); // 🚫 403 si ce n'est pas son article

    return view('articles.edit', compact('article'));
}

public function update(UpdateArticleRequest $request, $id)
{
    $article = Article::findOrFail($id);
    Gate::authorize('update', $article);

    $article->update($request->validated());
    return redirect()->route('articles.show', $article->id);
}

    public function destroy($id) {
    $article = Article::findOrFail($id);
    Gate::authorize('delete', $article);

    $article->delete();
    return redirect()->route('articles.index');
    }
}
