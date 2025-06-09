<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use NotificationChannels\WebPush\PushSubscription;
use Illuminate\Support\Facades\Log;

class WebPushController extends Controller
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

            // Usuń starą subskrypcję dla tego endpointu
            PushSubscription::where('endpoint', $subscription['endpoint'])->delete();

            // Utwórz nową subskrypcję
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

    public function sendNotification(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $user = auth()->user();
        
        if ($user->push_subscription) {
            $user->notify(new \App\Notifications\PushNotification($request->title, $request->body));
            return response()->json(['success' => true], 200);
        }

        return response()->json(['error' => 'No push subscription found'], 404);
    }
} 