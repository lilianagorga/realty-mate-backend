<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $user = User::where('email', 'liliana.g@email.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Liliana',
                'email' => 'liliana.g@email.com',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole($adminRole);
        }
    }
}
