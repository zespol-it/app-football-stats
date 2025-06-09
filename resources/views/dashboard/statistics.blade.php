<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statystyki') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Top strzelcy -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Top strzelcy</h3>
                        <div class="space-y-4">
                            @foreach($topScorers as $player)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-gray-500">{{ $loop->iteration }}.</span>
                                        <span class="font-medium">{{ $player->full_name }}</span>
                                        <span class="text-sm text-gray-500">{{ $player->teams->first() ? $player->teams->first()->name : 'Brak drużyny' }}</span>
                                    </div>
                                    <span class="font-bold">{{ $player->goals }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Top asystenci -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Top asystenci</h3>
                        <div class="space-y-4">
                            @foreach($topAssists as $player)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-gray-500">{{ $loop->iteration }}.</span>
                                        <span class="font-medium">{{ $player->full_name }}</span>
                                        <span class="text-sm text-gray-500">{{ $player->teams->first() ? $player->teams->first()->name : 'Brak drużyny' }}</span>
                                    </div>
                                    <span class="font-bold">{{ $player->assists }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Tabela ligowa -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:col-span-2">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Tabela ligowa</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Poz.</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Drużyna</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">M</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Z</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">R</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">P</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">BR+</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">BR-</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">RB</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">PKT</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($leagueTable as $team)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $team->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $team->matches_played }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $team->wins }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $team->draws }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $team->losses }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $team->goals_for }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $team->goals_against }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $team->goals_for - $team->goals_against }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold">{{ $team->points }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 