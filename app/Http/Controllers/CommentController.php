<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $donneesValidees = $request->validate([
            'auteur' => 'required|max:100',
            'contenu' => 'required|min:2',
        ]);

        $article = Article::findOrFail($articleId);

        // On crée le commentaire DIRECTEMENT via la relation
        $article->comments()->create($donneesValidees);

        return redirect()->route('articles.show', $article->id);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        Gate::authorize('delete', $comment); // 🚫 403 si pas modérateur

        $comment->delete();

        return back(); // retour à l'article
    }
}
