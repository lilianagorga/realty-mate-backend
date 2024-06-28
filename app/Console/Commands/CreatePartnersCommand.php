<?php

namespace App\Console\Commands;

use App\Traits\CreatePartners;
use Illuminate\Console\Command;

class CreatePartnersCommand extends Command
{
    use CreatePartners;

    protected $signature = 'make:partners';
    protected $description = 'Create partners from partners_data configuration';

    public function handle()
    {
        $this->createPartners();
        $this->info('Partners created or updated successfully.');
    }
}
