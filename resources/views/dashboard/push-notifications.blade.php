<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zarządzanie Powiadomieniami Push') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Powiadomień -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Status Powiadomień</h3>
                <div class="flex items-center space-x-4">
                    <div id="notification-status" class="text-gray-600">
                        Sprawdzanie statusu...
                    </div>
                    <button onclick="requestNotificationPermission()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Włącz Powiadomienia
                    </button>
                </div>
            </div>

            <!-- Test Powiadomień -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Test Powiadomień</h3>
                <div class="space-y-4">
                    <div>
                        <label for="notification-title" class="block text-sm font-medium text-gray-700">Tytuł</label>
                        <input type="text" id="notification-title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="Test Powiadomienia">
                    </div>
                    <div>
                        <label for="notification-body" class="block text-sm font-medium text-gray-700">Treść</label>
                        <textarea id="notification-body" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3">To jest testowe powiadomienie push!</textarea>
                    </div>
                    <button onclick="sendTestNotification()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Wyślij Testowe Powiadomienie
                    </button>
                </div>
            </div>

            <!-- Aktywne Subskrypcje -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Aktywne Subskrypcje</h3>
                <div id="subscriptions-list" class="space-y-4">
                    <div class="text-gray-600">Ładowanie subskrypcji...</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Sprawdź status powiadomień
        function checkNotificationStatus() {
            const status = document.getElementById('notification-status');
            if (Notification.permission === 'granted') {
                status.innerHTML = '<span class="text-green-600">✓ Powiadomienia włączone</span>';
            } else if (Notification.permission === 'denied') {
                status.innerHTML = '<span class="text-red-600">✗ Powiadomienia wyłączone</span>';
            } else {
                status.innerHTML = '<span class="text-yellow-600">? Powiadomienia nie skonfigurowane</span>';
            }
        }

        // Wyślij testowe powiadomienie
        function sendTestNotification() {
            const title = document.getElementById('notification-title').value;
            const body = document.getElementById('notification-body').value;

            if (Notification.permission !== 'granted') {
                alert('Najpierw musisz włączyć powiadomienia!');
                return;
            }

            fetch('/push-notification/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ title, body })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Powiadomienie zostało wysłane!');
                } else {
                    alert('Błąd: ' + (data.error || 'Nieznany błąd'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Wystąpił błąd podczas wysyłania powiadomienia');
            });
        }

        // Załaduj listę subskrypcji
        function loadSubscriptions() {
            fetch('/push-notification/subscriptions')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('subscriptions-list');
                if (data.subscriptions.length === 0) {
                    container.innerHTML = '<div class="text-gray-600">Brak aktywnych subskrypcji</div>';
                    return;
                }

                container.innerHTML = data.subscriptions.map(sub => `
                    <div class="border rounded p-4">
                        <div class="text-sm text-gray-500">Endpoint:</div>
                        <div class="font-mono text-sm break-all">${sub.endpoint}</div>
                        <div class="text-sm text-gray-500 mt-2">Utworzono: ${new Date(sub.created_at).toLocaleString()}</div>
                    </div>
                `).join('');
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('subscriptions-list').innerHTML = 
                    '<div class="text-red-600">Błąd podczas ładowania subskrypcji</div>';
            });
        }

        // Inicjalizacja
        document.addEventListener('DOMContentLoaded', () => {
            checkNotificationStatus();
            loadSubscriptions();
        });
    </script>
    @endpush
</x-app-layout> 