<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Drużyny') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($teams as $team)
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xl font-semibold">{{ $team->name }}</h3>
                                    <span class="text-sm text-gray-500">{{ $team->city }}</span>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-lg font-medium mb-2">Liga</h4>
                                    <div class="flex items-center justify-between">
                                        <span>{{ $team->league->name }}</span>
                                        <span class="text-sm text-gray-500">{{ $team->league->country }}</span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="text-lg font-medium mb-2">Zawodnicy</h4>
                                    <div class="space-y-2">
                                        @foreach($team->players->take(5) as $player)
                                            <div class="flex items-center justify-between">
                                                <span>{{ $player->name }}</span>
                                                <span class="text-sm text-gray-500">{{ $player->position }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-lg font-medium mb-2">Statystyki</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold">{{ $team->matches->count() }}</div>
                                            <div class="text-sm text-gray-500">Mecze</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold">{{ $team->players->count() }}</div>
                                            <div class="text-sm text-gray-500">Zawodnicy</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $teams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 