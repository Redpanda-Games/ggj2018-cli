<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputArgument;

class ManCommand extends Command
{
    public function configure(): void
    {
        $this
            ->setName('man')
            ->setDescription('Access the man page for installed programs.')
            ->addArgument('program', InputArgument::REQUIRED, 'the name of the program you want help for');
    }

    protected function handle()
    {
        $this->load();

        switch ($this->input->getArgument('program')) {
            case 'service':
                $this->output->writeln([
                    'service [service] start|stop|restart',
                    '',
                    'All services that are installed could be stopped.',
                    'If you want to start a service please contact your administrator.',
                ]);
                break;
            case 'network':
                $this->output->writeln([
                    'network [module] down|up',
                    '',
                    'You can turn of all modules, but be careful.',
                    'Most modules will restart after a short delay.',
                    'If you damage your system - it is your fault.'
                ]);
                break;
            default:
                $this->error('unknown program');
        }
    }
}