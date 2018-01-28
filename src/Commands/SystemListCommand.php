<?php

namespace App\Commands;

use App\System;

class SystemListCommand extends Command
{
    public function configure(): void
    {
        $this
            ->setName('system:check')
            ->setDescription('Checks all systems');
    }

    protected function handle()
    {
        $this->load();

        $data = [];
        foreach($this->octopus->systems as $system) {
            if($system instanceof System) {
                $data[] = [
                    $system->isActive() ? '<fg=green>*</> up' : '<fg=red>*</> down',
                    $system->getName(),
                    $system->getDescription(),
                    $system->getReward(),
                    $system->getMultiplier(),
                ];
            }
        }

        $this->table(['', 'Name', 'Module', 'Reward', 'Bonus'], $data);
    }
}