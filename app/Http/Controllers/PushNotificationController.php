<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\PushNotification;
use NotificationChannels\WebPush\PushSubscription;
use Illuminate\Support\Facades\Log;

class PushNotificationController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'endpoint' => 'required',
                'keys.p256dh' => 'required',
                'keys.auth' => 'required',
            ]);

            $user = auth()->user();
            if (!$user) {
                Log::error('Próba zapisania subskrypcji push bez zalogowanego użytkownika');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $subscription = $request->all();
            Log::info('Otrzymano subskrypcję push', ['user_id' => $user->id, 'subscription' => $subscription]);

            $user->pushSubscriptions()->create([
                'endpoint' => $subscription['endpoint'],
                'public_key' => $subscription['keys']['p256dh'],
                'auth_token' => $subscription['keys']['auth'],
            ]);

            Log::info('Subskrypcja push zapisana pomyślnie', ['user_id' => $user->id]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Błąd podczas zapisywania subskrypcji push', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
            ]);

            $user = auth()->user();
            if (!$user) {
                Log::error('Próba wysłania powiadomienia push bez zalogowanego użytkownika');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $subscriptions = $user->pushSubscriptions;
            if ($subscriptions->isEmpty()) {
                Log::warning('Brak aktywnych subskrypcji push', ['user_id' => $user->id]);
                return response()->json(['error' => 'Brak aktywnej subskrypcji push'], 400);
            }

            $title = $request->input('title');
            $body = $request->input('body');

            $user->notify(new PushNotification($title, $body));
            Log::info('Powiadomienie push wysłane pomyślnie', [
                'user_id' => $user->id,
                'title' => $title,
                'body' => $body
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Błąd podczas wysyłania powiadomienia push', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function subscriptions()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $subscriptions = $user->pushSubscriptions()
                ->select(['id', 'endpoint', 'created_at'])
                ->get();

            return response()->json(['subscriptions' => $subscriptions]);
        } catch (\Exception $e) {
            Log::error('Błąd podczas pobierania subskrypcji push', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $subscription = $user->pushSubscriptions()->findOrFail($id);
            $subscription->delete();

            Log::info('Subskrypcja push usunięta pomyślnie', [
                'user_id' => $user->id,
                'subscription_id' => $id
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Błąd podczas usuwania subskrypcji push', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'subscription_id' => $id
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 