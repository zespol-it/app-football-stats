<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Test Push Notification Button -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-4">Test Powiadomień Push</h2>
                    <button onclick="sendTestNotification()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Wyślij testowe powiadomienie
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path d="M8 15l4-4 4 4" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                    Wyniki meczów piłkarskich
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gospodarz</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Wynik</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goście</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rozgrywki</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentMatches as $match)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $match->match_date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $match->homeTeam->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-lg font-bold">{{ $match->home_score }} : {{ $match->away_score }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $match->awayTeam->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $match->league->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Brak meczów do wyświetlenia</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-8 text-sm text-gray-500">Ostatnie mecze z bazy danych.</div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function sendTestNotification() {
            if (Notification.permission !== 'granted') {
                alert('Najpierw musisz włączyć powiadomienia!');
                return;
            }

            const button = event.target;
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Wysyłanie...';

            fetch('/push-notification/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    title: 'Test Powiadomienia',
                    body: 'To jest testowe powiadomienie push!'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Powiadomienie zostało wysłane!');
                } else {
                    alert('Błąd podczas wysyłania powiadomienia: ' + (data.error || 'Nieznany błąd'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Wystąpił błąd podczas wysyłania powiadomienia');
            })
            .finally(() => {
                button.disabled = false;
                button.textContent = originalText;
            });
        }
    </script>
    @endpush
</x-app-layout> 