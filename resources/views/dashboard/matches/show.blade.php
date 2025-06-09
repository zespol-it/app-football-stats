<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mecz: {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
            </h2>
            <a href="{{ route('dashboard.matches') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Powrót do listy meczów
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Informacje o meczu -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1 text-right">
                                <div class="text-2xl font-bold">{{ $match->homeTeam->name }}</div>
                                <div class="text-sm text-gray-500">{{ $match->homeTeam->city }}</div>
                            </div>
                            <div class="mx-8 text-center">
                                <div class="text-4xl font-bold">{{ $match->home_score }} - {{ $match->away_score }}</div>
                                <div class="text-sm text-gray-500">{{ $match->date ? $match->date->format('d.m.Y H:i') : 'Data nieznana' }}</div>
                            </div>
                            <div class="flex-1">
                                <div class="text-2xl font-bold">{{ $match->awayTeam->name }}</div>
                                <div class="text-sm text-gray-500">{{ $match->awayTeam->city }}</div>
                            </div>
                        </div>
                        <div class="text-center text-gray-500">
                            {{ $match->league->name }}
                        </div>
                    </div>

                    <!-- Wydarzenia w meczu -->
                    <div>
                        <h3 class="text-lg font-medium mb-4">Wydarzenia w meczu</h3>
                        <div class="space-y-4">
                            @foreach($match->events->sortBy('minute') as $event)
                                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-sm font-medium">{{ $event->minute }}'</div>
                                        <div>
                                            <div class="font-medium">{{ $event->player->name ?? 'Brak nazwy' }}</div>
                                            <div class="text-sm text-gray-500">{{ $event->type }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium">{{ $event->team->name ?? 'Brak nazwy' }}</div>
                                        @if($event->assist_player_id)
                                            <div class="text-sm text-gray-500">Asysta: {{ $event->assistPlayer->name ?? 'Brak nazwy' }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Składy drużyn -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Gospodarze -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">{{ $match->homeTeam->name }}</h3>
                            <div class="space-y-2">
                                @foreach($match->homeTeam->players as $player)
                                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                        <div>
                                            <div class="font-medium">{{ $player->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $player->position }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-500">Gole: {{ $player->goals }}</div>
                                            <div class="text-sm text-gray-500">Asysty: {{ $player->assists }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Goście -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">{{ $match->awayTeam->name }}</h3>
                            <div class="space-y-2">
                                @foreach($match->awayTeam->players as $player)
                                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                        <div>
                                            <div class="font-medium">{{ $player->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $player->position }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-500">Gole: {{ $player->goals }}</div>
                                            <div class="text-sm text-gray-500">Asysty: {{ $player->assists }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 