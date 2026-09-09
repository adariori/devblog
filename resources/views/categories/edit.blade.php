<x-layout titre="Modifier la catégorie">

    <div class="mx-auto max-w-md">
        <header class="border-b-2 border-zinc-900 pb-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">Rubriques</p>
            <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-zinc-900">Modifier la catégorie</h1>
        </header>

        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nom" class="block text-sm font-medium text-zinc-700">Nom</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom', $category->nom) }}"
                       class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                @error('nom') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 border-t border-zinc-200 pt-6">
                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700">
                    Enregistrer
                </button>
                <a href="{{ route('categories.index') }}" class="text-sm font-semibold text-zinc-500 transition hover:text-zinc-900">
                    Annuler
                </a>
            </div>
        </form>

        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="mt-4"
              onsubmit="return confirm('Supprimer cette catégorie ?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                Supprimer la catégorie
            </button>
        </form>
    </div>

</x-layout>
