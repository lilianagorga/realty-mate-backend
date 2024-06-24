<?php

namespace App\Console\Commands;

use App\Traits\CreateTeamUsers;
use Illuminate\Console\Command;

class CreateTeam extends Command
{
    use CreateTeamUsers;
    protected $signature = 'make:team';
    protected $description = 'Create team from team_data configuration';

    public function handle()
    {
        $this->createTeamUsers();
        $this->info('Team users created or updated successfully.');
    }
}
