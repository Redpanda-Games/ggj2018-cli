<?php

namespace App\Items;

use App\Item;

class Graphiccard extends Item
{
    public static function make()
    {
        return (new self)
            ->setSlug('graphiccard')
            ->setName('Graphic card')
            ->setBasePps(8)
            ->setBasePrice(1100)
            ->setLevel(0)
        ;
    }
}