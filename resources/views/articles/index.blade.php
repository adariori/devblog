<x-layout titre="Tous les articles de DevBlog">
    <h1>{{ $titre }}</h1>

    <ul>
        @forelse ($articles as $article)
            <li><strong>{{ $article['titre'] }}</strong> - par {{ $article['auteur'] }}</li>
        @empty
            <li>Aucun article pour le moment</li>
        @endforelse
    </ul>
</x-layout>
