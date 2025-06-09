<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $player->name }}
            </h2>
            <a href="{{ route('dashboard.players') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Powrót do listy zawodników
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Informacje o zawodniku -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Informacje o zawodniku</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Drużyna</div>
                                <div class="text-lg font-medium">{{ $player->team->name ?? 'Brak nazwy' }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Pozycja</div>
                                <div class="text-lg font-medium">{{ $player->position ?? 'Brak pozycji' }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Liga</div>
                                <div class="text-lg font-medium">{{ $player->team->league->name ?? 'Brak ligi' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Statystyki -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Statystyki</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold">{{ $player->goals }}</div>
                                <div class="text-sm text-gray-500">Gole</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold">{{ $player->assists }}</div>
                                <div class="text-sm text-gray-500">Asysty</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold">{{ $player->yellow_cards }}</div>
                                <div class="text-sm text-gray-500">Żółte kartki</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold">{{ $player->red_cards }}</div>
                                <div class="text-sm text-gray-500">Czerwone kartki</div>
                            </div>
                        </div>
                    </div>

                    <!-- Ostatnie wydarzenia -->
                    <div>
                        <h3 class="text-lg font-medium mb-4">Ostatnie wydarzenia</h3>
                        <div class="space-y-4">
                            @foreach($player->events as $event)
                                <a href="{{ route('dashboard.matches.show', $event->match) }}" 
                                   class="block bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="text-sm font-medium">{{ $event->minute }}'</div>
                                            <div>
                                                <div class="font-medium">{{ $event->type }}</div>
                                                <div class="text-sm text-gray-500">{{ $event->match->homeTeam->name }} vs {{ $event->match->awayTeam->name }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-500">{{ $event->match->date->format('d.m.Y') }}</div>
                                            <div class="text-sm font-medium">{{ $event->match->home_score }} - {{ $event->match->away_score }}</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 