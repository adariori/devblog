<x-layout titre="Les auteurs de DevBlog">

    <header class="border-b-2 border-zinc-900 pb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">La rédaction</p>
        <h1 class="mt-2 font-serif text-4xl font-semibold tracking-tight text-zinc-900 sm:text-5xl">Auteurs</h1>
    </header>

    <div class="mt-10 grid gap-4 sm:grid-cols-2">
        @forelse ($auteurs as $id => $item)
            <a href="{{ route('auteurs.show', $id) }}"
               class="group flex items-start gap-4 rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-orange-300 hover:shadow-sm">
                <span class="flex size-12 shrink-0 items-center justify-center rounded-full bg-orange-50 font-serif text-lg font-semibold text-orange-700 ring-1 ring-inset ring-orange-600/20">
                    {{ \Illuminate\Support\Str::of($item['auteur'])->substr(0, 1)->upper() }}
                </span>
                <div class="min-w-0">
                    <p class="font-serif text-lg font-semibold text-zinc-900 transition group-hover:text-orange-700">
                        {{ $item['auteur'] }}
                    </p>
                    <p class="mt-1 text-sm text-zinc-600">{{ $item['bio'] }}</p>
                </div>
            </a>
        @empty
            <p class="py-16 text-center font-serif text-xl text-zinc-900 sm:col-span-2">Aucun auteur trouvé.</p>
        @endforelse
    </div>

</x-layout>
