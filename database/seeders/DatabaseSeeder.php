<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\League;
use App\Models\Team;
use App\Models\Player;
use App\Models\Game;
use App\Models\MatchEvent;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage users',
            'manage roles',
            'manage permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create admin role
        $adminRole = Role::create(['name' => 'admin']);

        // Assign all permissions to admin role
        $adminRole->givePermissionTo($permissions);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
        ]);

        // Assign admin role to admin user
        $admin->assignRole('admin');

        // Create leagues
        $premierLeague = League::create([
            'name' => 'Premier League',
            'country' => 'England',
            'level' => 1,
            'is_active' => true,
        ]);

        $laLiga = League::create([
            'name' => 'La Liga',
            'country' => 'Spain',
            'level' => 1,
            'is_active' => true,
        ]);

        // Create teams
        $manUtd = Team::create([
            'name' => 'Manchester United',
            'city' => 'Manchester',
            'country' => 'England',
            'league_id' => $premierLeague->id,
            'primary_color' => '#DA291C',
            'secondary_color' => '#FBE122',
            'is_active' => true,
        ]);

        $liverpool = Team::create([
            'name' => 'Liverpool',
            'city' => 'Liverpool',
            'country' => 'England',
            'league_id' => $premierLeague->id,
            'primary_color' => '#C8102E',
            'secondary_color' => '#F6EB61',
            'is_active' => true,
        ]);

        $barcelona = Team::create([
            'name' => 'Barcelona',
            'city' => 'Barcelona',
            'country' => 'Spain',
            'league_id' => $laLiga->id,
            'primary_color' => '#A50044',
            'secondary_color' => '#004D98',
            'is_active' => true,
        ]);

        $realMadrid = Team::create([
            'name' => 'Real Madrid',
            'city' => 'Madrid',
            'country' => 'Spain',
            'league_id' => $laLiga->id,
            'primary_color' => '#FFFFFF',
            'secondary_color' => '#FEBE10',
            'is_active' => true,
        ]);

        // Create players
        $players = [
            [
                'first_name' => 'Marcus',
                'last_name' => 'Rashford',
                'nickname' => 'Marcus Rashford',
                'birth_date' => '1997-10-31',
                'birth_place' => 'Manchester',
                'nationality' => 'England',
                'position' => 'FW',
                'shirt_number' => '10',
                'height' => 180,
                'weight' => 75,
                'preferred_foot' => 'right',
                'goals' => 15,
                'assists' => 8,
                'yellow_cards' => 2,
                'red_cards' => 0
            ],
            [
                'first_name' => 'Mohamed',
                'last_name' => 'Salah',
                'nickname' => 'Mo',
                'birth_date' => '1992-06-15',
                'birth_place' => 'Nagrig',
                'nationality' => 'Egyptian',
                'position' => 'FW',
                'shirt_number' => '11',
                'height' => 175,
                'weight' => 71,
                'preferred_foot' => 'left',
                'goals' => 20,
                'assists' => 10,
                'yellow_cards' => 1,
                'red_cards' => 0
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Lewandowski',
                'nickname' => 'Lewy',
                'birth_date' => '1988-08-21',
                'birth_place' => 'Warsaw',
                'nationality' => 'Polish',
                'position' => 'FW',
                'shirt_number' => '9',
                'height' => 185,
                'weight' => 81,
                'preferred_foot' => 'right',
                'goals' => 25,
                'assists' => 5,
                'yellow_cards' => 3,
                'red_cards' => 0
            ],
            [
                'first_name' => 'Karim',
                'last_name' => 'Benzema',
                'nickname' => 'KB9',
                'birth_date' => '1987-12-19',
                'birth_place' => 'Lyon',
                'nationality' => 'French',
                'position' => 'FW',
                'shirt_number' => '9',
                'height' => 185,
                'weight' => 81,
                'preferred_foot' => 'right',
                'goals' => 18,
                'assists' => 7,
                'yellow_cards' => 2,
                'red_cards' => 0
            ],
            [
                'first_name' => 'Jude',
                'last_name' => 'Bellingham',
                'position' => 'Midfielder',
                'birth_date' => '2003-06-29',
                'nationality' => 'England',
                'height' => 186,
                'weight' => 75,
                'is_active' => true,
            ],
        ];

        foreach ($players as $playerData) {
            $player = Player::create($playerData);
            $fullName = $player->first_name . ' ' . $player->last_name;
            // Assign players to teams
            if ($fullName === 'Marcus Rashford') {
                $player->teams()->attach($manUtd->id, [
                    'joined_date' => '2015-07-01',
                    'contract_type' => 'Full',
                    'shirt_number' => 10,
                ]);
            } elseif ($fullName === 'Mohamed Salah') {
                $player->teams()->attach($liverpool->id, [
                    'joined_date' => '2017-07-01',
                    'contract_type' => 'Full',
                    'shirt_number' => 11,
                ]);
            } elseif ($fullName === 'Robert Lewandowski') {
                $player->teams()->attach($barcelona->id, [
                    'joined_date' => '2022-07-01',
                    'contract_type' => 'Full',
                    'shirt_number' => 9,
                ]);
            } elseif ($fullName === 'Jude Bellingham') {
                $player->teams()->attach($realMadrid->id, [
                    'joined_date' => '2023-07-01',
                    'contract_type' => 'Full',
                    'shirt_number' => 5,
                ]);
            }
        }

        // Create matches
        $match1 = Game::create([
            'league_id' => $premierLeague->id,
            'home_team_id' => $manUtd->id,
            'away_team_id' => $liverpool->id,
            'match_date' => now()->addDays(7),
            'status' => 'scheduled',
            'venue' => 'Old Trafford',
        ]);

        $match2 = Game::create([
            'league_id' => $premierLeague->id,
            'home_team_id' => $liverpool->id,
            'away_team_id' => $manUtd->id,
            'match_date' => now()->addDays(14),
            'status' => 'scheduled',
            'venue' => 'Anfield',
        ]);

        $match3 = Game::create([
            'league_id' => $laLiga->id,
            'home_team_id' => $barcelona->id,
            'away_team_id' => $realMadrid->id,
            'match_date' => now()->addDays(10),
            'status' => 'scheduled',
            'venue' => 'Camp Nou',
        ]);

        $match4 = Game::create([
            'league_id' => $laLiga->id,
            'home_team_id' => $realMadrid->id,
            'away_team_id' => $barcelona->id,
            'match_date' => now()->addDays(17),
            'status' => 'scheduled',
            'venue' => 'Santiago Bernabéu',
        ]);

        // Create a match
        $match = Game::create([
            'league_id' => $premierLeague->id,
            'home_team_id' => $manUtd->id,
            'away_team_id' => $liverpool->id,
            'match_date' => now()->addDays(7),
            'home_score' => 2,
            'away_score' => 1,
            'status' => 'completed',
            'venue' => 'Old Trafford',
            'notes' => 'Exciting match with late winner'
        ]);

        // Create match events for the first match
        MatchEvent::create([
            'game_id' => $match->id,
            'player_id' => $players[0]['id'] ?? 1,
            'team_id' => $manUtd->id,
            'event_type' => 'goal',
            'minute' => 23,
            'description' => 'Goal scored by Marcus Rashford'
        ]);
    }
}
