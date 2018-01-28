<?php

namespace App\Systems;

use App\System;

class Proxy extends System
{
    public static function make()
    {
        return (new self)
            ->setSlug('proxy')
            ->setName('Proxy')
            ->setDescription('network')
            ->setCommand('network proxy down')
            ->setReward(15)
            ->setMultiplier(0.2)
            ->activate()
        ;
    }
}