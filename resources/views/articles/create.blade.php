<x-layout titre="Écrire un nouvel article">

    <div class="mx-auto max-w-2xl">
        <header class="border-b-2 border-zinc-900 pb-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">Nouvel article</p>
            <h1 class="mt-2 font-serif text-4xl font-semibold tracking-tight text-zinc-900">Écrire un article</h1>
        </header>

        <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data" class="mt-8 space-y-6">
            @csrf

            <div>
                <label for="titre" class="block text-sm font-medium text-zinc-700">Titre</label>
                <input type="text" name="titre" id="titre" value="{{ old('titre') }}"
                       class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                @error('titre') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contenu" class="block text-sm font-medium text-zinc-700">Contenu</label>
                <textarea name="contenu" id="contenu" rows="12"
                          class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">{{ old('contenu') }}</textarea>
                @error('contenu') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="cover" class="block text-sm font-medium text-zinc-700">Image de couverture</label>
                <input type="file" name="cover" id="cover" accept="image/*"
                       class="mt-1 block w-full text-sm text-zinc-600 file:mr-4 file:rounded-lg file:border-0 file:bg-zinc-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-zinc-700">
                @error('cover') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 border-t border-zinc-200 pt-6">
                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700">
                    Publier
                </button>
                <a href="{{ route('articles.index') }}" class="text-sm font-semibold text-zinc-500 transition hover:text-zinc-900">
                    Annuler
                </a>
            </div>
        </form>
    </div>

</x-layout>
