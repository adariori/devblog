<x-layout titre="{{ $article->titre }}">

    <h1>{{ $article->titre }}</h1>

    @if ($article->auteur)
        <p><em>Écrit par {{ $article->auteur }}</em></p>
    @endif

    <p>{{ $article->contenu }}</p>

    <a href="/articles">← Retour à la liste</a>

</x-layout>
