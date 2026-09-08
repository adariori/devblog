<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * GET /api/articles/{article}/comments
     * Liste les commentaires d'un article (public).
     */
    public function index(string $articleId)
    {
        $article = Article::findOrFail($articleId);

        return CommentResource::collection($article->comments);
    }

    /**
     * POST /api/articles/{article}/comments
     * Ajoute un commentaire à l'article (protégé par auth:sanctum).
     */
    public function store(Request $request, string $articleId)
    {
        $data = $request->validate([
            'auteur' => 'required|max:100',
            'contenu' => 'required|min:2',
        ]);

        $article = Article::findOrFail($articleId);
        $comment = $article->comments()->create($data);

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(201);
    }
}
