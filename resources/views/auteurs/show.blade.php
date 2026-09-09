<x-layout titre="{{ $auteur->name }}">

    <div class="mx-auto max-w-3xl">
        <a href="{{ route('auteurs.index') }}"
           class="text-xs font-semibold uppercase tracking-widest text-zinc-500 transition hover:text-zinc-900">
            Tous les auteurs
        </a>

        <div class="mt-8 flex items-center gap-5 border-b-2 border-zinc-900 pb-6">
            <span class="flex size-16 shrink-0 items-center justify-center rounded-full bg-orange-50 font-serif text-2xl font-semibold text-orange-700 ring-1 ring-inset ring-orange-600/20">
                {{ \Illuminate\Support\Str::of($auteur->name)->substr(0, 1)->upper() }}
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">Auteur</p>
                <h1 class="mt-1 font-serif text-3xl font-semibold tracking-tight text-zinc-900">{{ $auteur->name }}</h1>
                <p class="mt-1 text-sm text-zinc-500">
                    {{ $auteur->articles_count }} {{ \Illuminate\Support\Str::plural('article', $auteur->articles_count) }}
                </p>
            </div>
        </div>

        <div class="mt-8 divide-y divide-zinc-200">
            @forelse ($articles as $article)
                <article class="py-6 first:pt-0">
                    <div class="text-xs font-medium uppercase tracking-wider text-zinc-500">
                        {{ $article->created_at?->format('d/m/Y') }}
                    </div>
                    <h2 class="mt-1 font-serif text-xl font-semibold tracking-tight text-zinc-900">
                        <a href="{{ route('articles.show', $article->id) }}" class="transition hover:text-orange-700">
                            {{ $article->titre }}
                        </a>
                    </h2>
                    <p class="mt-1 text-zinc-600">{{ \Illuminate\Support\Str::limit(strip_tags($article->contenu), 160) }}</p>
                </article>
            @empty
                <p class="py-6 text-zinc-500">Aucun article.</p>
            @endforelse
        </div>
    </div>

</x-layout>
