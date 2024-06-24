<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateTeam extends Command
{
    protected $signature = 'make:team';
    protected $description = 'Create team from team_data configuration';

    public function handle()
    {
        $teamRole = Role::findOrCreate('team', 'web');

        $dashboardPermission = Permission::findOrCreate('dashboard', 'web');
        $managePropertiesPermission = Permission::findOrCreate('manageProperties', 'web');

        $teamRole->givePermissionTo($dashboardPermission);
        $teamRole->givePermissionTo($managePropertiesPermission);

        $teams = config('team_data');

        foreach ($teams as $team) {
            Team::create($team);
            $cleanedName = preg_replace('/\.+/', '.', str_replace(' ', '.', strtolower($team['name'])));
            $email = $cleanedName . '@example.com';

            $teamUser = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $team['name'],
                    'password' => Hash::make('Password123!'),
                    'email_verified_at' => now(),
                ]
            );
            $teamUser->assignRole($teamRole);
            $teamUser->givePermissionTo($dashboardPermission);
            $teamUser->givePermissionTo($managePropertiesPermission);
        }

        $this->info('Team users created or updated successfully.');
    }
}
