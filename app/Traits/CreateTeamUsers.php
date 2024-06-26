<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

trait CreateTeamUsers
{
    use ManageRolesAndPermissions;

    public function createTeamUsers(): void
    {
        $this->setupRolesAndPermissions();

        $teamRole = Role::findOrCreate('team', 'web');

        $teams = config('team_data');

        foreach ($teams as $team) {
            Team::create($team);
            $cleanedName = preg_replace('/\.+/', '.', str_replace(' ', '.', strtolower($team['name'])));
            $email = $cleanedName . '@email.com';

            $teamUser = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $team['name'],
                    'password' => Hash::make('Password123!'),
                    'email_verified_at' => now(),
                ]
            );

            $teamUser->assignRole($teamRole);
            $this->assignPermissionsToTeam($teamUser);
        }
    }

    protected function assignPermissionsToTeam($teamUser): void
    {
        $teamUser->givePermissionTo('dashboard');
        $teamUser->givePermissionTo('manageProperties');
    }
}
