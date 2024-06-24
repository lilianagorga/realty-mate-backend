<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::findOrCreate('admin', 'web');
        $teamRole = Role::findOrCreate('team', 'web');

        $dashboardPermission = Permission::findOrCreate('dashboard', 'web');
        $managePropertiesPermission = Permission::findOrCreate('manageProperties', 'web');

        $adminRole->givePermissionTo($dashboardPermission);
        $adminRole->givePermissionTo($managePropertiesPermission);

        $teamRole->givePermissionTo($dashboardPermission);
        $teamRole->givePermissionTo($managePropertiesPermission);

        $adminUser = User::where('email', 'liliana.g@email.com')->first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Liliana',
                'email' => 'liliana.g@email.com',
                'password' => Hash::make('Password123!'),
                'email_verified_at' => now(),
            ]);
            $adminUser->assignRole($adminRole);
            $adminUser->givePermissionTo($dashboardPermission);
            $adminUser->givePermissionTo($managePropertiesPermission);
        }

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
            $teamUser->givePermissionTo($dashboardPermission);
            $teamUser->givePermissionTo($managePropertiesPermission);
        }

    }
}
