<x-layout>
    <h1>Auteurs</h1>

    <ul>
        @forelse ($auteurs as $id => $item)
            <li>
                <strong>Auteur :</strong> {{ $item['auteur'] }} — {{ $item['bio'] }}
            </li>
        @empty
            <li>Aucun auteur trouvé.</li>
        @endforelse
    </ul>
</x-layout>
