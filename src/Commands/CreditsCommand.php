<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreditsCommand extends SymfonyCommand
{
    public function configure(): void
    {
        $this
            ->setName('credits')
            ->setDescription('Display the game credits.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<fg=blue>
 dP"Yb   dP""b8 888888  dP"Yb  88""Yb 88   88 .dP"Y8 
dP   Yb dP   `"   88   dP   Yb 88__dP 88   88 `Ybo." 
Yb   dP Yb        88   Yb   dP 88""Yb Y8   8P o.`Y8b 
 YbodP   YboodP   88    YbodP  88oodP `YbodP\' 8bodP\' 
</>');

        $output->writeln('');

        $output->writeln([
            '* <fg=magenta>Tom Witkowski</>          developer',
            '* <fg=magenta>Norman von Rechenberg</>  game designer',
            '* <fg=magenta>Eilin Pham</>             game designer',
            '* <fg=magenta>Maxim Simonenko</>        2d artist',
            '* <fg=magenta>Daniel Demmler</>         2d artist',
            '* <fg=magenta>Luise Stolz</>            2d artist',
            '* <fg=magenta>Eric Jentzsch</>          3d artist',
            '* <fg=magenta>Oliver Hartkopf</>        3d artist',
        ]);
    }
}