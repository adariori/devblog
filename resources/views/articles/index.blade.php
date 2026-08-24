<x-layout titre="Tous les articles de DevBlog">

    <h1>Tous les articles</h1>

    <ul>
        @forelse ($articles as $article)
            <li><a href="/articles/{{ $article->id }}"><strong>{{ $article->titre }}</strong></a> - par
                {{ $article->auteur }}</li>
        @empty
            <li>Aucun article pour le moment</li>
        @endforelse
    </ul>

    <a href="{{ route('articles.create') }}">+ Écrire un nouvel article</a>

</x-layout>
