<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use NotificationChannels\WebPush\PushSubscription;
use App\Notifications\PushNotification;

class PushNotificationCommand extends Command
{
    protected $signature = 'push:notification 
                            {action : Action to perform (test|list|clear|send-all)}
                            {--user= : User ID or email for specific actions}
                            {--title= : Notification title}
                            {--body= : Notification body}';

    protected $description = 'Manage push notifications';

    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'test':
                $this->sendTestNotification();
                break;
            case 'list':
                $this->listSubscriptions();
                break;
            case 'clear':
                $this->clearSubscriptions();
                break;
            case 'send-all':
                $this->sendToAllUsers();
                break;
            default:
                $this->error('Unknown action: ' . $action);
                return 1;
        }

        return 0;
    }

    protected function sendTestNotification()
    {
        $user = $this->getUser();
        if (!$user) return;

        $title = $this->option('title') ?? 'Test Powiadomienia';
        $body = $this->option('body') ?? 'To jest testowe powiadomienie push!';

        $this->info("Wysyłanie powiadomienia do użytkownika: {$user->email}");
        
        try {
            $user->notify(new PushNotification($title, $body));
            $this->info('Powiadomienie wysłane pomyślnie!');
        } catch (\Exception $e) {
            $this->error('Błąd podczas wysyłania powiadomienia: ' . $e->getMessage());
        }
    }

    protected function listSubscriptions()
    {
        $user = $this->getUser();
        if (!$user) return;

        $subscriptions = $user->pushSubscriptions;
        
        if ($subscriptions->isEmpty()) {
            $this->info('Brak aktywnych subskrypcji push.');
            return;
        }

        $this->info('Aktywne subskrypcje push:');
        $this->table(
            ['ID', 'Endpoint', 'Created At'],
            $subscriptions->map(function ($sub) {
                return [
                    'id' => $sub->id,
                    'endpoint' => $sub->endpoint,
                    'created_at' => $sub->created_at
                ];
            })
        );
    }

    protected function clearSubscriptions()
    {
        $user = $this->getUser();
        if (!$user) return;

        $count = $user->pushSubscriptions()->delete();
        $this->info("Usunięto {$count} subskrypcji push.");
    }

    protected function sendToAllUsers()
    {
        $title = $this->option('title') ?? 'Nowe powiadomienie';
        $body = $this->option('body') ?? 'To jest powiadomienie dla wszystkich użytkowników!';

        $users = User::whereHas('pushSubscriptions')->get();
        
        if ($users->isEmpty()) {
            $this->info('Brak użytkowników z aktywnymi subskrypcjami push.');
            return;
        }

        $this->info("Wysyłanie powiadomienia do {$users->count()} użytkowników...");
        
        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            try {
                $user->notify(new PushNotification($title, $body));
                $bar->advance();
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Błąd dla użytkownika {$user->email}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info('Zakończono wysyłanie powiadomień!');
    }

    protected function getUser()
    {
        $userIdentifier = $this->option('user');
        
        if (!$userIdentifier) {
            $this->error('Musisz podać ID lub email użytkownika (--user=)');
            return null;
        }

        $user = User::where('id', $userIdentifier)
            ->orWhere('email', $userIdentifier)
            ->first();

        if (!$user) {
            $this->error('Nie znaleziono użytkownika: ' . $userIdentifier);
            return null;
        }

        return $user;
    }
} 