<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin {email} {name?} {password?}';
    protected $description = 'Create an admin user';

    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name') ?? 'Admin';
        $password = $this->argument('password') ?? 'password';

        $user = User::where('email', $email)->first();

        if (!$user) {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);
            $this->info("Admin user {$email} created successfully.");
        } else {
            $this->info("User with email {$email} already exists.");
        }

        $this->info("Email verified at: " . $user->email_verified_at);
    }
}
