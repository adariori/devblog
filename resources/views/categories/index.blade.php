<x-layout titre="Categorie">

    <h1>Catégories</h1>
    <a href="{{ route('categories.create') }}">+ Nouvelle catégorie</a>


    <ul>
        @forelse ($categories as $category)
            <li><a href="{{ route('categories.edit', $category->id) }}"><strong>{{ $category->name }}</strong></a></li>
        @empty
            <li>Aucune categorie pour le moment</li>
        @endforelse
    </ul>

    <a href="{{ route('categories.create') }}">Ajouter une categorie</a>

</x-layout>
