<x-layout titre="Modifier la catégorie">

    <h1>Modifier la catégorie</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <p>
            <label>Nom :</label><br>
            <input type="text" name="name" value="{{ old('name', $category->name) }}">
            @error('name')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </p>
        <button type="submit">Enregistrer</button>
    </form>
</x-layout>
