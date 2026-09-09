<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6 text-gray-900">
                    <p class="font-serif text-lg text-gray-900">Bienvenue dans la zone réservée aux administrateurs.</p>
                    <p class="mt-1 text-sm text-gray-500">Accès restreint par le middleware <code>admin</code>.</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <a href="{{ route('articles.index') }}" class="rounded-lg bg-white p-5 shadow-sm transition hover:shadow">
                    <p class="text-sm font-medium text-gray-500">Contenu</p>
                    <p class="mt-1 font-semibold text-gray-900">Articles</p>
                </a>
                <a href="{{ route('categories.index') }}" class="rounded-lg bg-white p-5 shadow-sm transition hover:shadow">
                    <p class="text-sm font-medium text-gray-500">Contenu</p>
                    <p class="mt-1 font-semibold text-gray-900">Catégories</p>
                </a>
                <a href="{{ route('auteurs.index') }}" class="rounded-lg bg-white p-5 shadow-sm transition hover:shadow">
                    <p class="text-sm font-medium text-gray-500">Rédaction</p>
                    <p class="mt-1 font-semibold text-gray-900">Auteurs</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
