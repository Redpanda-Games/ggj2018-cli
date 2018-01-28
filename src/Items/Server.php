<?php

namespace App\Items;

use App\Item;

class Server extends Item
{
    public static function make()
    {
        return (new self)
            ->setSlug('server')
            ->setName('Server')
            ->setBasePps(47)
            ->setBasePrice(12000)
            ->setLevel(0)
        ;
    }
}