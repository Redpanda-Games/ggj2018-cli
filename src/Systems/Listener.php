<?php

namespace App\Systems;

use App\System;

class Listener extends System
{
    public static function make()
    {
        return (new self)
            ->setSlug('listener')
            ->setName('Listener')
            ->setDescription('network')
            ->setCommand('network listener down')
            ->setReward(50)
            ->setMultiplier(1)
            ->activate()
        ;
    }
}