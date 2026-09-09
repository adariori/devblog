<x-layout titre="{{ $article->titre }}">

    <article class="mx-auto max-w-2xl">

        <a href="{{ route('articles.index') }}"
           class="text-xs font-semibold uppercase tracking-widest text-zinc-500 transition hover:text-zinc-900">
            Retour aux articles
        </a>

        @if ($article->categories->isNotEmpty())
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach ($article->categories as $categorie)
                    <span class="inline-flex items-center rounded-full bg-orange-50 px-2.5 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/20">
                        {{ $categorie->nom }}
                    </span>
                @endforeach
            </div>
        @endif

        <h1 class="mt-4 font-serif text-4xl font-semibold leading-tight tracking-tight text-zinc-900 sm:text-5xl">
            {{ $article->titre }}
        </h1>

        <div class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-zinc-500">
            @if ($article->user)
                <a href="{{ route('auteurs.show', $article->user->id) }}"
                   class="font-medium text-zinc-700 transition hover:text-orange-700">{{ $article->user->name }}</a>
                <span class="text-zinc-300">/</span>
            @endif
            <span>{{ $article->created_at?->format('d/m/Y') }}</span>
        </div>

        @if ($article->cover_path)
            <img src="{{ Storage::disk('public')->url($article->cover_path) }}" alt="Couverture"
                 class="mt-8 aspect-[16/9] w-full rounded-2xl object-cover ring-1 ring-zinc-200">
        @endif

        <div class="mt-8 whitespace-pre-line text-lg leading-8 text-zinc-700">{{ $article->contenu }}</div>

        @if ($article->tags->isNotEmpty())
            <div class="mt-8 flex flex-wrap gap-x-3 gap-y-1 border-t border-zinc-200 pt-6 text-sm text-zinc-400">
                @foreach ($article->tags as $tag)
                    <span>#{{ $tag->nom }}</span>
                @endforeach
            </div>
        @endif

        @can('update', $article)
            <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-zinc-200 pt-6">
                <a href="{{ route('articles.edit', $article->id) }}"
                   class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                    Modifier
                </a>
                <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                      onsubmit="return confirm('Supprimer cet article ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                        Supprimer
                    </button>
                </form>
            </div>
        @endcan

    </article>

    <section class="mx-auto mt-16 max-w-2xl border-t-2 border-zinc-900 pt-10">
        <h2 class="font-serif text-2xl font-semibold tracking-tight text-zinc-900">
            Commentaires
            <span class="ml-1 align-middle text-base font-normal text-zinc-400">({{ $article->comments->count() }})</span>
        </h2>

        <div class="mt-6 space-y-4">
            @forelse ($article->comments as $comment)
                <div class="rounded-xl border border-zinc-200 bg-white p-4">
                    <p class="text-zinc-700">{{ $comment->contenu }}</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-zinc-500">{{ $comment->auteur }}</span>
                        @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                  onsubmit="return confirm('Supprimer ce commentaire ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-medium text-red-600 transition hover:underline">
                                    Supprimer
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <p class="text-zinc-500">Aucun commentaire pour l'instant.</p>
            @endforelse
        </div>

        <div class="mt-8 rounded-xl border border-zinc-200 bg-white p-6">
            <h3 class="font-serif text-lg font-semibold text-zinc-900">Laisser un commentaire</h3>

            <form action="{{ route('comments.store', $article->id) }}" method="POST" class="mt-4 space-y-4">
                @csrf

                <div>
                    <label for="auteur" class="block text-sm font-medium text-zinc-700">Votre nom</label>
                    <input type="text" name="auteur" id="auteur" value="{{ old('auteur') }}"
                           class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                    @error('auteur') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="contenu" class="block text-sm font-medium text-zinc-700">Votre commentaire</label>
                    <textarea name="contenu" id="contenu" rows="4"
                              class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">{{ old('contenu') }}</textarea>
                    @error('contenu') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700">
                    Envoyer
                </button>
            </form>
        </div>
    </section>

</x-layout>
