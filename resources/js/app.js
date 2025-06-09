import './bootstrap';

// Make functions globally available
window.requestNotificationPermission = requestNotificationPermission;
window.sendTestNotification = sendTestNotification;

// Web Push Notification
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(registration) {
            console.log('ServiceWorker registration successful');
            
            // Get VAPID public key from meta tag
            const vapidPublicKey = document.querySelector('meta[name="vapid-public-key"]').getAttribute('content');
            console.log('VAPID Public Key:', vapidPublicKey);
            
            // Check if we already have permission
            if (Notification.permission === 'granted') {
                // Zawsze próbuj subskrybować, nawet jeśli już granted
                subscribeToPush(registration, vapidPublicKey);
            } else if (Notification.permission !== 'denied') {
                console.log('Showing notification prompt');
                // If we haven't asked yet, show a custom prompt
                showNotificationPrompt(registration, vapidPublicKey);
            } else {
                console.log('Notification permission denied');
            }
        }).catch(function(error) {
            console.error('ServiceWorker registration failed:', error);
        });
    });
}

function showNotificationPrompt(registration, vapidPublicKey) {
    const prompt = document.createElement('div');
    prompt.className = 'fixed bottom-4 right-4 bg-white p-4 rounded-lg shadow-lg z-50';
    prompt.innerHTML = `
        <h3 class="text-lg font-semibold mb-2">Włącz powiadomienia</h3>
        <p class="text-gray-600 mb-4">Otrzymuj powiadomienia o nowych wynikach meczów!</p>
        <div class="flex gap-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="requestNotificationPermission(this, '${registration}', '${vapidPublicKey}')">
                Włącz
            </button>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300" onclick="this.parentElement.parentElement.remove()">
                Później
            </button>
        </div>
    `;
    document.body.appendChild(prompt);
}

function requestNotificationPermission(button, registration, vapidPublicKey) {
    button.disabled = true;
    button.textContent = 'Przetwarzanie...';

    Notification.requestPermission().then(function(permission) {
        if (permission === 'granted') {
            console.log('Notification permission granted');
            subscribeToPush(registration, vapidPublicKey);
            button.parentElement.parentElement.remove();
        } else {
            console.log('Notification permission denied');
            button.textContent = 'Odmówiono dostępu';
            button.classList.remove('bg-blue-500', 'hover:bg-blue-600');
            button.classList.add('bg-red-500', 'hover:bg-red-600');
            setTimeout(() => {
                button.parentElement.parentElement.remove();
            }, 3000);
        }
    });
}

function subscribeToPush(registration, vapidPublicKey) {
    if (!registration.pushManager) {
        console.error('Push notifications are not supported in this browser');
        alert('Twoja przeglądarka nie obsługuje powiadomień push. Spróbuj użyć Chrome, Firefox lub Edge.');
        return Promise.reject('Push notifications not supported');
    }

    console.log('Attempting to subscribe to push notifications...');
    return registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: vapidPublicKey
    }).then(function(subscription) {
        console.log('Push subscription successful:', subscription);
        
        // Send subscription to server
        return fetch('/push-notification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(subscription)
        }).then(response => {
            console.log('Server response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.json();
        }).then(data => {
            console.log('Server response data:', data);
            if (data.success) {
                console.log('Subscription saved successfully');
            } else {
                throw new Error(data.error || 'Unknown error');
            }
        });
    }).catch(function(error) {
        console.error('Push subscription failed:', error);
        alert('Nie udało się zasubskrybować powiadomień push: ' + error.message);
        throw error;
    });
}

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
    .then(response => {
        console.log('Test notification response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Test notification response data:', data);
        if (data.success) {
            alert('Powiadomienie zostało wysłane!');
        } else {
            alert('Błąd podczas wysyłania powiadomienia: ' + (data.error || 'Nieznany błąd'));
        }
    })
    .catch(error => {
        console.error('Error sending test notification:', error);
        alert('Wystąpił błąd podczas wysyłania powiadomienia: ' + error.message);
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = originalText;
    });
}
