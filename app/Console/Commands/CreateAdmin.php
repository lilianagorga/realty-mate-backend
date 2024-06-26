<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\CreateAdminUser;

class CreateAdmin extends Command
{
    use CreateAdminUser;

    protected $signature = 'make:admin {email} {name?} {password?}';
    protected $description = 'Create an admin user';

    public function handle(): int
    {
        $email = $this->argument('email');
        $name = $this->argument('name') ?? 'Admin';
        $password = $this->argument('password') ?? 'password';

        $this->createAdminUser($email, $name, $password);

        $this->info("Admin user {$email} created or updated successfully.");
        return 0;
    }
}
