<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Team;

class CreateTeamData extends Command
{
    protected $signature = 'make:team';
    protected $description = 'Create team data';

    public function handle()
    {
        $teams = config('team_data');

        foreach ($teams as $team) {
            Team::updateOrCreate(['name' => $team['name']], $team);
        }

        $this->info('Team data has been created successfully.');
    }
}
