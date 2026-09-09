<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    /**
     * GET /api/articles — liste publique.
     */
    public function index()
    {
        return ArticleResource::collection(
            Article::with('user', 'categories')->latest()->get()
        );
    }

    /**
     * POST /api/articles — protégé par auth:sanctum.
     */
    public function store(StoreArticleRequest $request)
    {
        // L'auteur est forcément le porteur du jeton.
        $article = $request->user()->articles()->create(
            $request->safe()->only(['titre', 'contenu'])
        );

        return (new ArticleResource($article))->response()->setStatusCode(201);
    }

    /**
     * GET /api/articles/{id} — détail public.
     */
    public function show(string $id)
    {
        return new ArticleResource(
            Article::with('user', 'categories', 'tags')->findOrFail($id)
        );
    }

    /**
     * PUT /api/articles/{id} — protégé + réservé au propriétaire.
     */
    public function update(UpdateArticleRequest $request, string $id)
    {
        $article = Article::findOrFail($id);
        Gate::authorize('update', $article);

        $article->update($request->safe()->only(['titre', 'contenu']));

        return new ArticleResource($article);
    }

    /**
     * DELETE /api/articles/{id} — protégé + réservé au propriétaire.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        Gate::authorize('delete', $article);

        $article->delete();

        return response()->json(null, 204);
    }
}
