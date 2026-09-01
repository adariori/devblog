<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'DevBlog') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
        <div class="min-h-screen flex flex-col items-center justify-center px-6 py-10">
            @if (Route::has('login'))
                <nav class="absolute top-0 right-0 p-6 text-sm">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif

            <main class="text-center max-w-2xl">
                <h1 class="text-4xl font-semibold sm:text-5xl">{{ config('app.name', 'DevBlog') }}</h1>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    Bienvenue sur DevBlog. Connectez-vous ou créez un compte pour commencer à publier.
                </p>

                <div class="mt-8 flex items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-md bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                            Aller au dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                            Se connecter
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-md border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                                Créer un compte
                            </a>
                        @endif
                    @endauth
                </div>
            </main>
        </div>
    </body>
</html>
