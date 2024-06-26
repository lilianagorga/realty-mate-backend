<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\CreatePrices;

class CreatePricesCommand extends Command
{
    use CreatePrices;
    protected $signature = 'make:prices';
    protected $description = 'Create default prices from configuration';
    public function handle(): int
    {
        $this->createPrices();
        $this->info('Prices created successfully.');
        return 0;
    }
}
