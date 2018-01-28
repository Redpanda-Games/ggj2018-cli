<?php

namespace App;

use App\Items\Graphiccard;
use App\Items\Keyboard;
use App\Items\Raspberrypi;
use App\Items\Server;
use App\Systems\Clock;
use App\Systems\Firewall;
use App\Systems\Listener;
use App\Systems\Mysql;
use App\Systems\Proxy;
use Carbon\Carbon;

class Octopus implements \JsonSerializable
{
    const FILEPATH = __DIR__.'/../storage/octopus.json';

    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->default();
        $this->fill($attributes);
    }

    protected function default()
    {
        $this->attributes = [
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
            'highscore' => 0,
            'credits' => 0,
            'items' => [
                Keyboard::make(),
                Raspberrypi::make(),
                Graphiccard::make(),
                Server::make(),
            ],
            'systems' => [
                Clock::make(),
                Mysql::make(),

                Proxy::make(),
                Firewall::make(),
                Listener::make(),
            ],
        ];
    }

    /*
     * base_prices: 15, 100, 1100, 12000, 130000, 1400000, 20000000, 330000000
     * base_pps: 0.1, 1, 8, 47, 260, 1400, 7800, 44000
     */

    public function fill(array $attributes = [])
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        foreach($this->attributes['items'] as $key => $item) {
            if(is_array($item)) {
                $className = '\App\Items\\'.ucfirst($item['slug']);
                if(class_exists($className)) {
                    $this->attributes['items'][$key] = new $className($item);
                }
            } elseif($item instanceof Item) {
                $this->attributes['items'][$key] = $item;
            }
        }
        foreach($this->attributes['systems'] as $key => $system) {
            if(is_array($system)) {
                $className = '\App\Systems\\'.ucfirst($system['slug']);
                if(class_exists($className)) {
                    $this->attributes['systems'][$key] = new $className($system);
                }
            } elseif($system instanceof Item) {
                $this->attributes['systems'][$key] = $system;
            }
        }
    }

    public function getItemAmount()
    {
        return count(array_filter($this->items, function(Item $item) {
            return $item->getLevel() > 0;
        }));
    }

    public function getLevel()
    {
        return array_sum(array_column($this->toArray()['items'], 'level'));
    }

    public function getPps()
    {
        $pps = 0;
        foreach($this->items as $item) {
            $pps += $item->getPps();
        }
        return $pps;
    }

    public function getMultiplier()
    {
        $multiplier = 1;
        foreach($this->systems as $system) {
            $multiplier += $system->isActive() ? 0 : $system->getMultiplier();
        }
        return $multiplier;
    }

    public function addCredits($amount)
    {
        $amount *= $this->getMultiplier();
        $this->attributes['credits'] += $amount;
        $this->attributes['highscore'] += $amount;
    }

    public function reactivate()
    {
        $systems = $this->systems;
        foreach($systems as $i => $system) {
            if(!$system->isActive() && (int)mt_rand(0, 2) == 2) {
                $system->activate();
                $systems[$i] = $system;
                $this->systems = $systems;
                break;
            }
        }
    }

    public static function load()
    {
        if(!file_exists(self::FILEPATH)) {
            throw new \RuntimeException('please boot the system first');
        }

        return new static(json_decode(file_get_contents(self::FILEPATH), true));
    }

    public function save($reactivate = true)
    {
        $last = new Carbon($this->attributes['updated_at']);
        $now = Carbon::now();
        $diff = $last->diffInSeconds($now, true);
        $earning = $this->getPps() * $diff;
        $this->addCredits($earning);

        if($reactivate) {
            $this->reactivate();
        }

        $this->attributes['updated_at'] = $now->toDateTimeString();
        return file_put_contents(self::FILEPATH, $this->toJson());
    }

    public function toArray()
    {
        return $this->reduceToArray($this->attributes);
    }

    protected function reduceToArray(array $input)
    {
        $array = [];
        foreach($input as $key => $value) {
            if($value instanceof Carbon) {
                $array[$key] = $value->toDateTimeString();
            } elseif(method_exists($value, 'toArray')) {
                $array[$key] = $value->toArray();
            } elseif(is_array($value)) {
                $array[$key] = $this->reduceToArray($value);
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    public function toJson()
    {
        return $this->jsonSerialize();
    }

    public function jsonSerialize()
    {
        return json_encode($this->toArray());
    }

    public function __get($name)
    {
        return $this->attributes[$name];
    }

    public function __set($name, $value)
    {
        return $this->attributes[$name] = $value;
    }
}