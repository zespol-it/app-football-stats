<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $league->name }}
            </h2>
            <a href="{{ route('dashboard.leagues') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Powrót do listy lig
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Informacje o lidze -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Informacje o lidze</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Kraj</div>
                                <div class="text-lg font-medium">{{ $league->country }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Liczba drużyn</div>
                                <div class="text-lg font-medium">{{ $league->teams->count() }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Liczba meczów</div>
                                <div class="text-lg font-medium">{{ $league->matches->count() }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Drużyny -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Drużyny</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($league->teams as $team)
                                <a href="{{ route('dashboard.teams.show', $team) }}" 
                                   class="block bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-medium">{{ $team->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $team->city }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-500">Mecze: {{ $team->matches->count() }}</div>
                                            <div class="text-sm text-gray-500">Zawodnicy: {{ $team->players->count() }}</div>
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
                            @foreach($league->matches as $match)
                                <a href="{{ route('dashboard.matches.show', $match) }}" 
                                   class="block bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 text-right">
                                            <div class="font-medium">{{ $match->homeTeam->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $match->homeTeam->city }}</div>
                                        </div>
                                        <div class="mx-4 text-center">
                                            <div class="text-lg font-bold">{{ $match->home_score }} - {{ $match->away_score }}</div>
                                            <div class="text-sm text-gray-500">{{ $match->date ? $match->date->format('d.m.Y H:i') : 'Data nieznana' }}</div>
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