<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ligi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($leagues as $league)
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center justify-between mb-4">
                                    @if($league->logo)
                                        <img src="{{ $league->logo }}" alt="{{ $league->name }}" class="w-16 h-16 object-contain">
                                    @endif
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $league->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $league->country }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span>Liczba drużyn:</span>
                                        <span class="font-medium">{{ $league->teams->count() }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span>Liczba meczów:</span>
                                        <span class="font-medium">{{ $league->matches->count() }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Status:</span>
                                        <span class="font-medium {{ $league->is_active ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $league->is_active ? 'Aktywna' : 'Nieaktywna' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <a href="{{ route('dashboard.leagues.show', $league) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                        Szczegóły
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 