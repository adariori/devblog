<x-layout titre="Catégories">

    <header class="flex flex-wrap items-end justify-between gap-4 border-b-2 border-zinc-900 pb-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">Rubriques</p>
            <h1 class="mt-2 font-serif text-4xl font-semibold tracking-tight text-zinc-900">Catégories</h1>
        </div>
        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center gap-1.5 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700">
            + Nouvelle catégorie
        </a>
    </header>

    <div class="mt-10">
        @forelse ($categories as $category)
            <a href="{{ route('categories.edit', $category->id) }}"
               class="flex items-center justify-between border-b border-zinc-200 py-4 transition hover:text-orange-700">
                <span class="font-serif text-lg font-medium text-zinc-900">{{ $category->nom }}</span>
                <span class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Modifier</span>
            </a>
        @empty
            <p class="py-16 text-center font-serif text-xl text-zinc-900">Aucune catégorie pour le moment.</p>
        @endforelse
    </div>

</x-layout>
