<?php

namespace App\Commands;

use App\Item;

class ItemListCommand extends Command
{
    public function configure(): void
    {
        $this
            ->setName('item:list')
            ->setDescription('Displays all items');
    }

    protected function handle()
    {
        $this->load();

        $data = [];
        foreach($this->octopus->items as $item) {
            if($item instanceof Item) {
                $data[] = [
                    $item->getName(),
                    $item->getLevel(),
                    $item->getPrice(),
                    $item->getPps(),
                ];
            }
        }

        $this->table(['Name', 'Level', 'Price', 'DNA per Second'], $data);
    }
}