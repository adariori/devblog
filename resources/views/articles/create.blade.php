<x-layout>

    <h1>Ecrire un nouvel article</h1>

    <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <p>
            <label>Titre :</label>
            <input type="text" name="titre" value="{{ old('titre') }}">
            @error('titre')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Contenu :</label>
            <textarea name="contenu">{{ old('contenu') }}</textarea>
            @error('contenu')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Image de couverture :</label><br>
            <input type="file" name="cover">
            @error('cover') <span style="color: red;">{{ $message }}</span>  
            @enderror
        </p>

        <button type="submit">Publier</button>
    </form>



</x-layout>
