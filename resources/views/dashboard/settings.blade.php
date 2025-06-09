<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ustawienia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('dashboard.settings.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Powiadomienia -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Powiadomienia</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="notifications_enabled" name="notifications_enabled" 
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                           {{ auth()->user()->notifications_enabled ? 'checked' : '' }}>
                                    <label for="notifications_enabled" class="ml-2 text-sm text-gray-600">
                                        Włącz powiadomienia push
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" id="email_notifications" name="email_notifications" 
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                           {{ auth()->user()->email_notifications ? 'checked' : '' }}>
                                    <label for="email_notifications" class="ml-2 text-sm text-gray-600">
                                        Włącz powiadomienia email
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Preferencje -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Preferencje</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="default_league" class="block text-sm font-medium text-gray-700">
                                        Domyślna liga
                                    </label>
                                    <select id="default_league" name="default_league" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @foreach($leagues as $league)
                                            <option value="{{ $league->id }}" {{ auth()->user()->default_league_id == $league->id ? 'selected' : '' }}>
                                                {{ $league->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="language" class="block text-sm font-medium text-gray-700">
                                        Język
                                    </label>
                                    <select id="language" name="language" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="pl" {{ auth()->user()->language == 'pl' ? 'selected' : '' }}>Polski</option>
                                        <option value="en" {{ auth()->user()->language == 'en' ? 'selected' : '' }}>English</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Zapisz zmiany -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Zapisz zmiany
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 