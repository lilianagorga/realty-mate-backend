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
        $adminRole = Role::findOrCreate('admin', 'web');
        $dashboardPermission = Permission::findOrCreate('dashboard', 'web');
        $adminRole->givePermissionTo($dashboardPermission);

        $user = User::where('email', 'liliana.g@email.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Liliana',
                'email' => 'liliana.g@email.com',
                'password' => Hash::make('Password123!'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole($adminRole);
            $user->givePermissionTo($dashboardPermission);
        }
    }
}
