<?php

namespace App\Commands;

use App\System;

class HackCommand extends Command
{
    public function configure(): void
    {
        $this
            ->setName('hack')
            ->setDescription('Hack into the enemy system');
    }

    protected function handle()
    {
        $this->load();

        $start = time();
        $answer = $this->io->ask('$');
        $end = time();
        $diff = $end - $start;

        if($answer == 'man service') {
            $this->output->writeln([
                'service [service] start|stop|restart',
                '',
                'All services that are installed could be stopped.',
                'If you want to start a service please contact your administrator.',
            ]);

            return true;
        } elseif($answer == 'man network') {
            $this->output->writeln([
                'network [module] down|up',
                '',
                'You can turn of all modules, but be careful.',
                'Most modules will restart after a short delay.',
                'If you damage your system - it is your fault.'
            ]);

            return true;
        }

        if ($diff <= 10) {
            $systems = $this->octopus->systems;
            foreach($systems as $i => $system) {
                if ($system instanceof System && $answer == $system->getCommand()) {
                    if($system->isActive()) {
                        $system->disable();
                        $systems[$i] = $system;
                        $this->octopus->systems = $systems;
                        $earnings = max(2, ceil(($this->octopus->getLevel() / 2) + floor($system->getReward() / ceil($diff / 5))));
                        $this->octopus->addCredits($earnings);
                        $this->success($system->getName() . ' down - transmitted ' . $earnings . ' DNA');
                        return true;
                    } else {
                        $this->error('already down');
                        return false;
                    }
                } elseif($answer == 'transmit') {
                    $earnings = max(2, ceil(($this->octopus->getLevel() / 2)));
                    $this->octopus->addCredits($earnings);
                    $this->success('transmitted ' . $earnings . ' DNA');
                    return true;
                }
            }
            $this->error('permission denied');
        } else {
            $this->error('timeout reached');
        }
    }
}