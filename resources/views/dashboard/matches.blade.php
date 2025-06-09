<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mecze') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($matches as $match)
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-center">
                                            <div class="text-lg font-semibold">{{ $match->homeTeam->name }}</div>
                                            <div class="text-3xl font-bold">{{ $match->home_score }}</div>
                                        </div>
                                        <div class="text-gray-500">vs</div>
                                        <div class="text-center">
                                            <div class="text-lg font-semibold">{{ $match->awayTeam->name }}</div>
                                            <div class="text-3xl font-bold">{{ $match->away_score }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500">{{ $match->match_date ? $match->match_date->format('d.m.Y H:i') : 'Data nieznana' }}</div>
                                        <div class="text-sm font-medium">{{ $match->league->name }}</div>
                                    </div>
                                </div>

                                @if($match->events->count() > 0)
                                    <div class="mt-4">
                                        <h4 class="text-lg font-medium mb-2">Wydarzenia</h4>
                                        <div class="space-y-2">
                                            @foreach($match->events as $event)
                                                <div class="flex items-center justify-between text-sm">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="font-medium">{{ $event->minute }}'</span>
                                                        <span>{{ $event->player->name }}</span>
                                                        <span class="text-gray-500">{{ $event->type }}</span>
                                                    </div>
                                                    <span class="text-gray-500">{{ $event->team->name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $matches->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 