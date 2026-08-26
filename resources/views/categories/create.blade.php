<x-layout titre="Nouvelle catégorie">

    <h2>Ajoutez une catégorie</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <p>
            <label>Nom :</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </p>
        <button type="submit">Créer</button>
    </form>

</x-layout>
