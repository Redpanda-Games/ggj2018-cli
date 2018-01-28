<?php

namespace App\Systems;

use App\System;

class Clock extends System
{
    public static function make()
    {
        return (new self)
            ->setSlug('clock')
            ->setName('Clock')
            ->setDescription('service')
            ->setCommand('service clock stop')
            ->setReward(10)
            ->setMultiplier(0.1)
            ->activate()
        ;
    }
}