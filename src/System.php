<?php

namespace App;

abstract class System
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

    public function setDescription($value)
    {
        $this->attributes['description'] = $value;

        return $this;
    }

    public function getDescription()
    {
        return $this->attributes['description'];
    }

    public function setCommand($value)
    {
        $this->attributes['command'] = $value;

        return $this;
    }

    public function getCommand()
    {
        return $this->attributes['command'];
    }

    public function setReward($value)
    {
        $this->attributes['reward'] = $value;

        return $this;
    }

    public function getReward()
    {
        return $this->attributes['reward'];
    }

    public function setMultiplier($value)
    {
        $this->attributes['multiplier'] = $value;

        return $this;
    }

    public function getMultiplier()
    {
        return $this->attributes['multiplier'];
    }

    public function isActive()
    {
        return (bool) $this->attributes['active'];
    }

    public function activate()
    {
        $this->attributes['active'] = true;

        return $this;
    }

    public function disable()
    {
        $this->attributes['active'] = false;

        return $this;
    }

    public function toArray()
    {
        return $this->attributes;
    }

    abstract public static function make();
}