<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use App\Traits\CreateTeamUsers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use CreateTeamUsers;
    public function run(): void
    {
        $adminRole = Role::findOrCreate('admin', 'web');
        $teamRole = Role::findOrCreate('team', 'web');

        $dashboardPermission = Permission::findOrCreate('dashboard', 'web');
        $managePropertiesPermission = Permission::findOrCreate('manageProperties', 'web');
        $teamManagementPermission = Permission::findOrCreate('teamManagement', 'web');

        $adminRole->givePermissionTo($dashboardPermission);
        $adminRole->givePermissionTo($managePropertiesPermission);
        $adminRole->givePermissionTo($teamManagementPermission);

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
            $adminUser->givePermissionTo($teamManagementPermission);
        }

        $this->createTeamUsers();

    }
}
