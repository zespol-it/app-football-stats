<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zawodnicy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($players as $player)
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xl font-semibold">{{ $player->full_name ?? 'Brak nazwy' }}</h3>
                                    <span class="text-sm text-gray-500">{{ $player->position ?? 'Brak pozycji' }}</span>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-lg font-medium mb-2">Drużyny</h4>
                                    <div class="space-y-2">
                                        @foreach($player->teams as $team)
                                            <div class="flex items-center justify-between">
                                                <span>{{ $team->name }}</span>
                                                <span class="text-sm text-gray-500">{{ $team->league->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="text-lg font-medium mb-2">Statystyki</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm text-gray-500">Gole</div>
                                            <div class="font-medium">{{ $player->goals }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">Asysty</div>
                                            <div class="font-medium">{{ $player->assists }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">Żółte kartki</div>
                                            <div class="font-medium">{{ $player->yellow_cards }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">Czerwone kartki</div>
                                            <div class="font-medium">{{ $player->red_cards }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $players->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 