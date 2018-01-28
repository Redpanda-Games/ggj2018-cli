<?php

namespace App\Commands;

use Symfony\Component\Console\Command\ListCommand as SymfonyListCommand;

class ListCommand extends SymfonyListCommand
{
    public function configure(): void
    {
        parent::configure();
        $this->setHidden(true);
    }
}