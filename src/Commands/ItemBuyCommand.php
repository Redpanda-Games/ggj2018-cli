<?php

namespace App\Commands;

use App\Item;
use Symfony\Component\Console\Input\InputArgument;

class ItemBuyCommand extends Command
{
    public function configure(): void
    {
        $this
            ->setName('item:buy')
            ->setDescription('Buy an item')
            ->addArgument('slug', InputArgument::OPTIONAL, 'the slug of the item to buy');
    }

    protected function handle()
    {
        $this->load();

        $items = $this->octopus->items;
        $itemSlugs = [];
        $itemNames = [];
        foreach($items as $key => $item) {
            $itemSlugs[$item->getName()] = $item->getSlug();
            $itemNames[] = $item->getName();
        }

        $slug = $this->input->getArgument('slug');
        if(empty($slug)) {
            $id = $this->io->choice('which one?', $itemNames);
            $slug = $itemSlugs[$id];
        }

        foreach($items as $key => $item) {
            if($item instanceof Item && $item->getSlug() == $slug) {
                $price = $item->getPrice();
                if($this->octopus->credits >= $price) {
                    $this->octopus->credits -= $price;
                    $item->incLevel();
                    $items[$key] = $item;
                    $this->octopus->items = $items;
                    $this->success('upgraded '.$item->getName().' to level '.$item->getLevel().' with '.$price.' DNA');
                    return true;
                }
                $this->error('not enough DNA - '.$this->octopus->credits.'/'.$price);
                return false;
            }
        }
        $this->error('no item found');
        return false;
    }
}