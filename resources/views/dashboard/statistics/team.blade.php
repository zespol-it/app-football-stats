<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Statystyki: {{ $team->name }}
            </h2>
            <a href="{{ route('dashboard.statistics') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Powrót do statystyk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informacje o drużynie -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $team->matches_count }}</div>
                            <div class="text-sm text-gray-500">Rozegrane mecze</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $team->wins_count }}</div>
                            <div class="text-sm text-gray-500">Zwycięstwa</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $team->goals_for }}</div>
                            <div class="text-sm text-gray-500">Zdobyte gole</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $team->points }}</div>
                            <div class="text-sm text-gray-500">Punkty</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Najlepsi strzelcy -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Najlepsi strzelcy</h3>
                        <div class="space-y-4">
                            @foreach($topScorers as $player)
                                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-sm font-medium">{{ $loop->iteration }}.</div>
                                        <div>
                                            <div class="font-medium">{{ $player->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $player->position }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-bold">{{ $player->goals }}</div>
                                        <div class="text-sm text-gray-500">gole</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Najlepsi asystenci -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Najlepsi asystenci</h3>
                        <div class="space-y-4">
                            @foreach($topAssists as $player)
                                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-sm font-medium">{{ $loop->iteration }}.</div>
                                        <div>
                                            <div class="font-medium">{{ $player->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $player->position }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-bold">{{ $player->assists }}</div>
                                        <div class="text-sm text-gray-500">asysty</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ostatnie mecze -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Ostatnie mecze</h3>
                    <div class="space-y-4">
                        @foreach($recentMatches as $match)
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="flex-1 text-right">
                                    <div class="font-medium">{{ $match->homeTeam->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $match->homeTeam->city }}</div>
                                </div>
                                <div class="mx-8 text-center">
                                    <div class="text-xl font-bold">{{ $match->home_score }} - {{ $match->away_score }}</div>
                                    <div class="text-sm text-gray-500">{{ $match->date->format('d.m.Y') }}</div>
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium">{{ $match->awayTeam->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $match->awayTeam->city }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 