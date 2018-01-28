<?php

namespace App\Systems;

use App\System;

class Mysql extends System
{
    public static function make()
    {
        return (new self)
            ->setSlug('mysql')
            ->setName('MySQL')
            ->setDescription('service')
            ->setCommand('service mysql stop')
            ->setReward(5)
            ->setMultiplier(0.1)
            ->activate()
        ;
    }
}