<?php

namespace App\Items;

use App\Item;

class Raspberrypi extends Item
{
    public static function make()
    {
        return (new self)
            ->setSlug('raspberrypi')
            ->setName('Raspberry Pi')
            ->setBasePps(1)
            ->setBasePrice(100)
            ->setLevel(0)
        ;
    }
}