<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user', 'categories')->latest()->paginate(8);

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create', [
            'categories' => Category::orderBy('nom')->get(),
            'tags' => Tag::orderBy('nom')->get(),
        ]);
    }

    public function store(StoreArticleRequest $request)
    {
        $data = $request->safe()->only(['titre', 'contenu']);

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        $article = $request->user()->articles()->create($data);
        $article->categories()->sync($request->input('categories', []));
        $article->tags()->sync($request->input('tags', []));

        return redirect()->route('articles.index');
    }

    public function show($id)
    {
        $article = Article::with('user', 'categories', 'tags', 'comments')->findOrFail($id);

        return view('articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::with('categories', 'tags')->findOrFail($id);
        Gate::authorize('update', $article);

        return view('articles.edit', [
            'article' => $article,
            'categories' => Category::orderBy('nom')->get(),
            'tags' => Tag::orderBy('nom')->get(),
        ]);
    }

    public function update(UpdateArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        Gate::authorize('update', $article);

        $data = $request->safe()->only(['titre', 'contenu']);

        if ($request->hasFile('cover')) {
            if ($article->cover_path) {
                Storage::disk('public')->delete($article->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        $article->update($data);
        $article->categories()->sync($request->input('categories', []));
        $article->tags()->sync($request->input('tags', []));

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
