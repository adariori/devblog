<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $titre ?? 'DevBlog' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600|fraunces:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-full flex-col bg-stone-50 font-sans text-zinc-700 antialiased">

    <header class="sticky top-0 z-20 border-b-2 border-zinc-900 bg-stone-50/85 backdrop-blur">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
            <a href="{{ url('/articles') }}" class="font-serif text-2xl font-bold tracking-tight text-zinc-900">
                DevBlog<span class="text-orange-600">.</span>
            </a>

            <nav class="flex items-center gap-5 text-xs font-semibold uppercase tracking-widest text-zinc-500">
                <a href="{{ route('articles.index') }}" class="transition hover:text-zinc-900">Articles</a>
                <a href="{{ route('auteurs.index') }}" class="hidden transition hover:text-zinc-900 sm:inline">Auteurs</a>

                @auth
                    <a href="{{ route('categories.index') }}" class="hidden transition hover:text-zinc-900 sm:inline">Catégories</a>
                    <a href="{{ route('dashboard') }}" class="hidden transition hover:text-zinc-900 sm:inline">Mon espace</a>
                    <a href="{{ route('articles.create') }}"
                       class="inline-flex items-center gap-1.5 rounded-lg bg-orange-600 px-3 py-1.5 text-white shadow-sm transition hover:bg-orange-700">
                        Écrire
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="contents">
                        @csrf
                        <button type="submit" class="transition hover:text-zinc-900">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="transition hover:text-zinc-900">Connexion</a>
                @endauth
            </nav>
        </div>
    </header>

    @if (session('status') || session('success'))
        <div class="mx-auto mt-4 w-full max-w-5xl px-4 sm:px-6">
            <div class="rounded-lg border border-orange-200 bg-orange-50 px-4 py-3 text-sm font-medium text-orange-800">
                {{ session('status') ?? session('success') }}
            </div>
        </div>
    @endif

    <main class="flex-1">
        <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-14">
            {{ $slot }}
        </div>
    </main>

    <footer class="border-t border-zinc-200">
        <div class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-2 px-4 py-8 text-sm text-zinc-500 sm:flex-row sm:px-6">
            <p class="font-serif text-base text-zinc-900">DevBlog<span class="text-orange-600">.</span></p>
            <p>© {{ date('Y') }} — fait avec Laravel.</p>
        </div>
    </footer>

</body>

</html>
