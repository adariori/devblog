<x-layout titre="{{ $article->titre }}">

    <h1>{{ $article->titre }}</h1>

    @if ($article->user)
        <p><em>Écrit par {{ $article->user->name }}</em></p>
    @endif

    <p>{{ $article->contenu }}</p>

    @if ($article->categories->isNotEmpty())
        <p>
            Catégories :
            @foreach ($article->categories as $categorie)
                <strong>{{ $categorie->nom }}</strong>
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </p>
    @endif

    @if ($article->tags->isNotEmpty())
        <p>
            Tags :
            @foreach ($article->tags as $tag)
                #{{ $tag->nom }}@if (!$loop->last)
                    ,
                @endif
            @endforeach
        </p>
    @endif

    <h3>Commentaires</h3>

    @forelse ($article->comments as $comment)
        <div style="border: 1px solid #ccc; padding: 8px; margin: 8px 0;">
            <p>{{ $comment->contenu }}</p>
            <small>— {{ $comment->auteur }}</small>
        </div>
    @empty
        <p>Aucun commentaire pour l'instant. Soyez le premier !</p>
    @endforelse

    <h4>Laisser un commentaire</h4>

    <form action="{{ route('comments.store', $article->id) }}" method="POST">
        @csrf
        <p><input type="text" name="auteur" placeholder="Votre nom"></p>
        <p>
            <textarea name="contenu" placeholder="Votre commentaire"></textarea>
        </p>
        <button type="submit">Envoyer</button>
    </form>

    <a href="{{ route('articles.edit', $article->id) }}">✏️ Modifier cet article</a>

    <br>

    <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Voulez vous vraiment supprimer cet article ?')">Supprimer
            cet
            article</button>
    </form>

    <a href="/articles">← Retour à la liste</a>

</x-layout>
