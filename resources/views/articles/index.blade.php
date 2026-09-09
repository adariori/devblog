<x-layout titre="Tous les articles de DevBlog">

    <header class="border-b-2 border-zinc-900 pb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">Le journal</p>
        <h1 class="mt-2 font-serif text-4xl font-semibold tracking-tight text-zinc-900 sm:text-5xl">
            Tous les articles
        </h1>
    </header>

    <div class="mt-10 divide-y divide-zinc-200">
        @forelse ($articles as $article)
            <article class="group flex flex-col gap-5 py-8 first:pt-0 sm:flex-row">
                @if ($article->cover_path)
                    <a href="{{ route('articles.show', $article->id) }}" class="block shrink-0 sm:w-56">
                        <img src="{{ Storage::url($article->cover_path) }}" alt=""
                             class="aspect-[16/10] w-full rounded-xl object-cover ring-1 ring-zinc-200">
                    </a>
                @endif

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-medium uppercase tracking-wider text-zinc-500">
                        <span>{{ $article->user->name ?? 'Inconnu' }}</span>
                        <span class="text-zinc-300">/</span>
                        <span>{{ $article->created_at?->format('d/m/Y') }}</span>
                    </div>

                    <h2 class="mt-2 font-serif text-2xl font-semibold tracking-tight text-zinc-900">
                        <a href="{{ route('articles.show', $article->id) }}" class="transition group-hover:text-orange-700">
                            {{ $article->titre }}
                        </a>
                    </h2>

                    <p class="mt-2 line-clamp-2 text-zinc-600">
                        {{ \Illuminate\Support\Str::limit(strip_tags($article->contenu), 180) }}
                    </p>

                    @if ($article->categories->isNotEmpty())
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($article->categories as $categorie)
                                <span class="inline-flex items-center rounded-full bg-orange-50 px-2.5 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/20">
                                    {{ $categorie->nom }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="py-16 text-center">
                <p class="font-serif text-xl text-zinc-900">Aucun article pour le moment.</p>
                @auth
                    <a href="{{ route('articles.create') }}"
                       class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700">
                        Écrire le premier article
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

</x-layout>
