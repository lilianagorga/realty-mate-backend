<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

trait CreateAdminUser
{
    use ManageRolesAndPermissions;

    public function createAdminUser(string $email, string $name = 'Admin', string $password = 'password'): void
    {
        $this->setupRolesAndPermissions();

        $adminRole = Role::findOrCreate('admin', 'web');

        $adminUser = User::where('email', $email)->first();

        if (!$adminUser) {
            $emailVerifiedAt = now();
            $adminUser = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => $emailVerifiedAt,
            ]);

            $adminUser->assignRole($adminRole);
            $this->assignPermissionsToAdmin($adminUser);
        } else {
            $adminUser->email_verified_at = now();
            $adminUser->save();
        }
    }

    protected function assignPermissionsToAdmin($adminUser): void
    {
        $adminUser->givePermissionTo('dashboard');
        $adminUser->givePermissionTo('manageProperties');
        $adminUser->givePermissionTo('teamManagement');
        $adminUser->givePermissionTo('priceManagement');
    }
}
