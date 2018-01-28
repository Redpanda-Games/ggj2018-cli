<?php

namespace App\Systems;

use App\System;

class Firewall extends System
{
    public static function make()
    {
        return (new self)
            ->setSlug('firewall')
            ->setName('Firewall')
            ->setDescription('network')
            ->setCommand('network firewall down')
            ->setReward(20)
            ->setMultiplier(0.5)
            ->activate()
        ;
    }
}