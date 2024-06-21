<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin {email} {name?} {password?}';
    protected $description = 'Create an admin user';

    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name') ?? 'Admin';
        $password = $this->argument('password') ?? 'password';

        $adminRole = Role::findOrCreate('admin', 'web');

        $dashboardPermission = Permission::findOrCreate('dashboard', 'web');

        $adminRole->givePermissionTo($dashboardPermission);

        $user = User::where('email', $email)->first();

        if (!$user) {
            $emailVerifiedAt = now();
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => $emailVerifiedAt,
            ]);

            $user->assignRole($adminRole);
            $user->givePermissionTo($dashboardPermission);
            $this->info("Admin user {$email} created successfully.");
            $this->info("Email verified at timestamp during creation: " . $emailVerifiedAt);
        } else {
            $this->info("User with email {$email} already exists.");
            $user->email_verified_at = now();
            $user->save();
            $this->info("Email verified at timestamp for existing user: " . $user->email_verified_at);
        }

        $this->info("Email verified at: " . $user->email_verified_at);
        if (empty($user->email_verified_at)) {
            $this->error("The email_verified_at field is not set.");
        }
        if ($user->hasRole('admin')) {
            $this->info("User has admin role");
        } else {
            $this->info("User does not have admin role");
        }
    }
}
