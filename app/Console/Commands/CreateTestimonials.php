<?php

namespace App\Console\Commands;

use App\Traits\CreateTestimonialUsers;
use Illuminate\Console\Command;

class CreateTestimonials extends Command
{
    use CreateTestimonialUsers;

    protected $signature = 'make:testimonials';
    protected $description = 'Create testimonials from testimonials_data configuration';

    public function handle()
    {
        $this->createTestimonialUsers();
        $this->info('Testimonials created or updated successfully.');
    }
}
