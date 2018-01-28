<?php

namespace App;

abstract class Item
{
    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function fill(array $attributes = [])
    {
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    public function setSlug($value)
    {
        $this->attributes['slug'] = $value;

        return $this;
    }

    public function getSlug()
    {
        return $this->attributes['slug'];
    }

    public function setName($value)
    {
        $this->attributes['name'] = $value;

        return $this;
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function setLevel($value)
    {
        $this->attributes['level'] = $value;

        return $this;
    }

    public function incLevel($value = 1)
    {
        $this->attributes['level'] += $value;

        return $this;
    }

    public function getLevel()
    {
        return $this->attributes['level'];
    }

    public function setBasePps($value)
    {
        $this->attributes['base_pps'] = $value;

        return $this;
    }

    public function getBasePps()
    {
        return $this->attributes['base_pps'];
    }

    public function getPps()
    {
        return floor(($this->getBasePps() * $this->getLevel()) * 100) / 100;
    }

    public function setBasePrice($value)
    {
        $this->attributes['base_price'] = $value;

        return $this;
    }

    public function getBasePrice()
    {
        return $this->attributes['base_price'];
    }

    public function getPrice()
    {
        return ceil($this->getBasePrice() * pow(1.15, $this->getLevel()));
    }

    public function toArray()
    {
        return $this->attributes;
    }

    abstract public static function make();
}