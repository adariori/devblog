<x-layout titre="Modifier l'article">

    <h1>Modifier : {{ $article->titre }}</h1>

    <form action="{{ route('articles.update', $article->id) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label>Titre :</label><br>
            <input type="text" name="titre" value="{{ old('titre', $article->titre) }}">
            @error('titre')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Contenu :</label><br>
            <textarea name="contenu">{{ old('contenu', $article->contenu) }}</textarea>
            @error('contenu')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </p>

        <button type="submit">Enregistrer les modifications</button>
    </form>

</x-layout>
