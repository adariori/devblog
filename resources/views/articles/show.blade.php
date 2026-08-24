<x-layout titre="{{ $article->titre }}">

    <h1>{{ $article->titre }}</h1>

    @if ($article->auteur)
        <p><em>Écrit par {{ $article->auteur }}</em></p>
    @endif

    <p>{{ $article->contenu }}</p>

    <a href="{{ route('articles.edit', $article->id) }}">✏️ Modifier cet article</a>

    <br>

    <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Voulez vous vraiment supprimer cet artcile ?')">Supprimer cet
            article</button>
    </form>

    <a href="/articles">← Retour à la liste</a>

</x-layout>
