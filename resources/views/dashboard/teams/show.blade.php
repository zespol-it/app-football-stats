<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $team->name }}
            </h2>
            <a href="{{ route('dashboard.teams') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Powrót do listy drużyn
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Informacje o drużynie -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Informacje o drużynie</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Liga</div>
                                <div class="text-lg font-medium">{{ $team->league->name }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Miasto</div>
                                <div class="text-lg font-medium">{{ $team->city }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Liczba zawodników</div>
                                <div class="text-lg font-medium">{{ $team->players->count() }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Zawodnicy -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Zawodnicy</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($team->players as $player)
                                <a href="{{ route('dashboard.players.show', $player) }}" 
                                   class="block bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-medium">{{ $player->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $player->position }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-500">Gole: {{ $player->goals }}</div>
                                            <div class="text-sm text-gray-500">Asysty: {{ $player->assists }}</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Ostatnie mecze -->
                    <div>
                        <h3 class="text-lg font-medium mb-4">Ostatnie mecze</h3>
                        <div class="space-y-4">
                            @foreach($team->matches as $match)
                                <a href="{{ route('dashboard.matches.show', $match) }}" 
                                   class="block bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 text-right">
                                            <div class="font-medium">{{ $match->homeTeam->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $match->homeTeam->city }}</div>
                                        </div>
                                        <div class="mx-4 text-center">
                                            <div class="text-lg font-bold">{{ $match->home_score }} - {{ $match->away_score }}</div>
                                            <div class="text-sm text-gray-500">{{ $match->date->format('d.m.Y H:i') }}</div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium">{{ $match->awayTeam->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $match->awayTeam->city }}</div>
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