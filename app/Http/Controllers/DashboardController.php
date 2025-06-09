<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\League;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $recentMatches = Game::with(['homeTeam', 'awayTeam', 'league'])
            ->whereNotNull('match_date')
            ->orderBy('match_date', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboard.index', compact('recentMatches'));
    }

    /**
     * Display the leagues list.
     */
    public function leagues()
    {
        $leagues = League::withCount(['teams', 'matches'])->paginate(12);
        return view('dashboard.leagues', compact('leagues'));
    }

    /**
     * Display the teams list.
     */
    public function teams()
    {
        $teams = Team::with(['league', 'players'])
            ->whereHas('league')
            ->paginate(12);
        return view('dashboard.teams', compact('teams'));
    }

    /**
     * Display the players list.
     */
    public function players()
    {
        $players = Player::with(['teams'])
            ->whereHas('teams')
            ->paginate(12);
        return view('dashboard.players', compact('players'));
    }

    /**
     * Display the matches list.
     */
    public function matches()
    {
        $matches = Game::with(['homeTeam', 'awayTeam', 'league'])
            ->whereNotNull('match_date')
            ->paginate(12);
        return view('dashboard.matches', compact('matches'));
    }

    /**
     * Display the statistics page.
     */
    public function statistics()
    {
        // Pobierz top strzelców
        $topScorers = Player::with(['teams'])
            ->whereHas('teams')
            ->orderBy('goals', 'desc')
            ->take(5)
            ->get();

        // Pobierz top asystentów
        $topAssists = Player::with(['teams'])
            ->whereHas('teams')
            ->orderBy('assists', 'desc')
            ->take(5)
            ->get();

        // Pobierz tabelę ligową
        $leagueTable = Team::with(['league'])
            ->whereHas('league')
            ->get()
            ->map(function ($team) {
                $homeMatches = $team->homeMatches()->whereNotNull('home_score')->get();
                $awayMatches = $team->awayMatches()->whereNotNull('away_score')->get();
                
                $wins = $homeMatches->where('home_score', '>', 'away_score')->count() +
                       $awayMatches->where('away_score', '>', 'home_score')->count();
                
                $draws = $homeMatches->where('home_score', '=', 'away_score')->count() +
                        $awayMatches->where('away_score', '=', 'home_score')->count();
                
                $losses = $homeMatches->where('home_score', '<', 'away_score')->count() +
                         $awayMatches->where('away_score', '<', 'home_score')->count();
                
                $goalsFor = $homeMatches->sum('home_score') + $awayMatches->sum('away_score');
                $goalsAgainst = $homeMatches->sum('away_score') + $awayMatches->sum('home_score');
                
                return (object)[
                    'name' => $team->name,
                    'matches_played' => $wins + $draws + $losses,
                    'wins' => $wins,
                    'draws' => $draws,
                    'losses' => $losses,
                    'goals_for' => $goalsFor,
                    'goals_against' => $goalsAgainst,
                    'points' => ($wins * 3) + $draws
                ];
            })
            ->sortByDesc('points')
            ->values();

        return view('dashboard.statistics', compact('topScorers', 'topAssists', 'leagueTable'));
    }

    /**
     * Display the settings page.
     */
    public function settings()
    {
        $leagues = League::all();
        return view('dashboard.settings', compact('leagues'));
    }

    /**
     * Display the league details.
     */
    public function leagueShow(League $league)
    {
        $league->load(['teams', 'matches' => function ($query) {
            $query->latest()->take(5);
        }]);
        return view('dashboard.leagues.show', compact('league'));
    }

    /**
     * Display the team details.
     */
    public function teamShow(Team $team)
    {
        $team->load(['league', 'players', 'homeMatches' => function ($query) {
            $query->latest()->take(5);
        }, 'awayMatches' => function ($query) {
            $query->latest()->take(5);
        }]);
        return view('dashboard.teams.show', compact('team'));
    }

    /**
     * Display the player details.
     */
    public function playerShow(Player $player)
    {
        $player->load(['teams', 'events' => function ($query) {
            $query->latest()->take(5);
        }]);
        return view('dashboard.players.show', compact('player'));
    }

    /**
     * Display the match details.
     */
    public function matchShow(Game $match)
    {
        $match->load(['homeTeam', 'awayTeam', 'league', 'events']);
        return view('dashboard.matches.show', compact('match'));
    }

    /**
     * Display the league statistics.
     */
    public function leagueStatistics(League $league)
    {
        $league->load(['teams', 'matches']);
        return view('dashboard.statistics.league', compact('league'));
    }

    /**
     * Display the team statistics.
     */
    public function teamStatistics(Team $team)
    {
        $team->load(['league', 'players', 'homeMatches', 'awayMatches']);
        return view('dashboard.statistics.team', compact('team'));
    }

    /**
     * Display the player statistics.
     */
    public function playerStatistics(Player $player)
    {
        $player->load(['teams', 'events']);
        return view('dashboard.statistics.player', compact('player'));
    }
} 