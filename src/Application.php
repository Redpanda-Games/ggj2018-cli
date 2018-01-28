<?php

namespace App;

use App\Commands\ListCommand;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication
{
    protected function getDefaultCommands()
    {
        return [
            new ListCommand(),
        ];
    }
}