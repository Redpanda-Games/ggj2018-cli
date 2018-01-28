<?php

namespace App\Items;

use App\Item;

class Keyboard extends Item
{
    public static function make()
    {
        return (new self)
            ->setSlug('keyboard')
            ->setName('Keyboard')
            ->setBasePps(0.1)
            ->setBasePrice(15)
            ->setLevel(0)
        ;
    }
}