<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Statystyki: {{ $league->name }}
            </h2>
            <a href="{{ route('dashboard.statistics') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Powrót do statystyk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tabela ligowa -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Tabela ligowa</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poz.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Drużyna</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">M</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Z</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">R</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">P</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">BR+</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">BR-</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">+/-</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">PKT</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($league->teams as $team)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $team->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $team->city }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $team->matches_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $team->wins_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $team->draws_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $team->losses_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $team->goals_for }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $team->goals_against }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $team->goals_for - $team->goals_against }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium text-gray-900">{{ $team->points }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                            <div class="text-sm text-gray-500">{{ $player->team->name }}</div>
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
                                            <div class="text-sm text-gray-500">{{ $player->team->name }}</div>
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
        </div>
    </div>
</x-app-layout> 