<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, $articleId)
    {
        $article = Article::findOrFail($articleId);

        // On crée le commentaire DIRECTEMENT via la relation
        $article->comments()->create($request->validated());

        return redirect()->route('articles.show', $article->id);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        Gate::authorize('delete', $comment); // 403 si l'utilisateur n'est pas modérateur

        $comment->delete();

        return back(); // retour à l'article
    }
}
