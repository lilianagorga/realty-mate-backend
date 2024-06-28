<?php

namespace Database\Seeders;

use App\Traits\CreateAdminUser;
use App\Traits\CreatePartners;
use App\Traits\CreatePrices;
use App\Traits\CreateTeamUsers;
use App\Traits\CreateTestimonialUsers;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use CreateAdminUser, CreateTeamUsers, CreatePrices, CreateTestimonialUsers, CreatePartners;

    public function run(): void
    {
        $this->createAdminUser('liliana.g@email.com', 'Liliana', 'Password123!');
        $this->createTeamUsers();
        $this->createPrices();
        $this->createTestimonialUsers();
        $this->createPartners();
    }
}
