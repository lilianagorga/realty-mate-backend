<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $adminRoleApi = Role::findOrCreate('admin', 'api');
        $adminRoleWeb = Role::findOrCreate('admin', 'web');

        $dashboardPermissionApi = Permission::findOrCreate('dashboard', 'api');
        $dashboardPermissionWeb = Permission::findOrCreate('dashboard', 'web');

        $adminRoleApi->givePermissionTo($dashboardPermissionApi);
        $adminRoleWeb->givePermissionTo($dashboardPermissionWeb);

        $user = User::where('email', 'liliana.g@email.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Liliana',
                'email' => 'liliana.g@email.com',
                'password' => Hash::make('Password123!'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole($adminRoleApi);
            $user->assignRole($adminRoleWeb);
            $user->givePermissionTo($dashboardPermissionApi);
            $user->givePermissionTo($dashboardPermissionWeb);
        }
    }
}
