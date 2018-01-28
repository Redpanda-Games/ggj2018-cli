<?php

namespace App\Commands;

use Carbon\Carbon;

class StatusCommand extends Command
{
    public function configure(): void
    {
        $this
            ->setName('status')
            ->setDescription('Displays current stats');
    }

    public function handle()
    {
        $this->load();
        $this->save(false);

        $this->io->listing([
            'booted: '.(new Carbon($this->octopus->created_at))->diffForHumans(),
            'Highscore: '.$this->octopus->highscore,
            'DNA: '.$this->octopus->credits,
            'Items: '.$this->octopus->getItemAmount(),
            'Level: '.$this->octopus->getLevel(),
            'DNA per Second: '.$this->octopus->getPps(),
            'Multiplier: '.$this->octopus->getMultiplier(),
        ]);
    }
}