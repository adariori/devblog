<x-layout titre="{{ $auteur['auteur'] }}">

    <div class="mx-auto max-w-2xl">
        <a href="{{ route('auteurs.index') }}"
           class="text-xs font-semibold uppercase tracking-widest text-zinc-500 transition hover:text-zinc-900">
            ← Tous les auteurs
        </a>

        <div class="mt-8 flex items-center gap-5">
            <span class="flex size-16 shrink-0 items-center justify-center rounded-full bg-orange-50 font-serif text-2xl font-semibold text-orange-700 ring-1 ring-inset ring-orange-600/20">
                {{ \Illuminate\Support\Str::of($auteur['auteur'])->substr(0, 1)->upper() }}
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">Auteur</p>
                <h1 class="mt-1 font-serif text-3xl font-semibold tracking-tight text-zinc-900">{{ $auteur['auteur'] }}</h1>
            </div>
        </div>

        <p class="mt-8 border-t border-zinc-200 pt-6 text-lg leading-8 text-zinc-700">{{ $auteur['bio'] }}</p>
    </div>

</x-layout>
