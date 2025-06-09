<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Statystyki: {{ $player->name }}
            </h2>
            <a href="{{ route('dashboard.statistics') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Powrót do statystyk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informacje o zawodniku -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $player->matches_count }}</div>
                            <div class="text-sm text-gray-500">Rozegrane mecze</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $player->goals }}</div>
                            <div class="text-sm text-gray-500">Gole</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $player->assists }}</div>
                            <div class="text-sm text-gray-500">Asysty</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $player->yellow_cards + $player->red_cards }}</div>
                            <div class="text-sm text-gray-500">Kartki</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Statystyki meczowe -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Statystyki meczowe</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Rozegrane mecze</div>
                                <div class="font-medium">{{ $player->matches_count }}</div>
                            </div>
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Minuty na boisku</div>
                                <div class="font-medium">{{ $player->minutes_played }}</div>
                            </div>
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Żółte kartki</div>
                                <div class="font-medium">{{ $player->yellow_cards }}</div>
                            </div>
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Czerwone kartki</div>
                                <div class="font-medium">{{ $player->red_cards }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statystyki strzeleckie -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Statystyki strzeleckie</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Gole</div>
                                <div class="font-medium">{{ $player->goals }}</div>
                            </div>
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Asysty</div>
                                <div class="font-medium">{{ $player->assists }}</div>
                            </div>
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Strzały</div>
                                <div class="font-medium">{{ $player->shots }}</div>
                            </div>
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500">Strzały celne</div>
                                <div class="font-medium">{{ $player->shots_on_target }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ostatnie wydarzenia -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Ostatnie wydarzenia</h3>
                    <div class="space-y-4">
                        @foreach($recentEvents as $event)
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="text-sm font-medium">{{ $event->minute }}'</div>
                                    <div>
                                        <div class="font-medium">{{ $event->type }}</div>
                                        <div class="text-sm text-gray-500">{{ $event->match->homeTeam->name }} vs {{ $event->match->awayTeam->name }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium">{{ $event->match->date->format('d.m.Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $event->match->home_score }} - {{ $event->match->away_score }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 