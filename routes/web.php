<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebPushController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Leagues
        Route::get('/leagues', [DashboardController::class, 'leagues'])->name('leagues');
        Route::get('/leagues/{league}', [DashboardController::class, 'leagueShow'])->name('leagues.show');

        // Teams
        Route::get('/teams', [DashboardController::class, 'teams'])->name('teams');
        Route::get('/teams/{team}', [DashboardController::class, 'teamShow'])->name('teams.show');

        // Players
        Route::get('/players', [DashboardController::class, 'players'])->name('players');
        Route::get('/players/{player}', [DashboardController::class, 'playerShow'])->name('players.show');

        // Matches
        Route::get('/matches', [DashboardController::class, 'matches'])->name('matches');
        Route::get('/matches/{match}', [DashboardController::class, 'matchShow'])->name('matches.show');

        // Statistics
        Route::get('/statistics', [DashboardController::class, 'statistics'])->name('statistics');
        Route::get('/statistics/league/{league}', [DashboardController::class, 'leagueStatistics'])->name('statistics.league');
        Route::get('/statistics/team/{team}', [DashboardController::class, 'teamStatistics'])->name('statistics.team');
        Route::get('/statistics/player/{player}', [DashboardController::class, 'playerStatistics'])->name('statistics.player');

        // Settings
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
        Route::put('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    });

    // Web Push routes
    Route::post('/webpush', [WebPushController::class, 'store'])->name('webpush.store');
    Route::post('/webpush/delete', [WebPushController::class, 'destroy'])->name('webpush.destroy');
    Route::post('/webpush/test', [PushNotificationController::class, 'sendTest'])->name('webpush.test');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Push Notification routes
    Route::post('/push-notification', [WebPushController::class, 'store']);
    Route::post('/push-notification/send', [PushNotificationController::class, 'send']);
    Route::get('/push-notification/subscriptions', [PushNotificationController::class, 'subscriptions']);
    Route::delete('/push-notification/subscriptions/{id}', [PushNotificationController::class, 'destroy']);
    Route::get('/dashboard/push-notifications', function () {
        return view('dashboard.push-notifications');
    })->name('dashboard.push-notifications');
});

require __DIR__.'/auth.php';
