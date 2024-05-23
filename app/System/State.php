<?php

namespace Ovxivan\Telegram\System;

use Ovxivan\Telegram\Requests\User;

class State
{
    const DEFAULT = 'default';
    const DIR = 'states';
    private string $state = self::DEFAULT;
    private static self|null $instance;
    public function __construct()
    {
        $this->start();
    }

    public static function make():void
    {
        self::$instance = new self();
    }


    private function start():void
    {
        if (!file_exists($this->getFilename())) {
            file_put_contents($this->getFilename(), self::DEFAULT);
        }
        $this->setState(file_get_contents($this->getFilename()));
    }

    public static function isDefault()
    {
        return self::$instance->getState()==self::DEFAULT;
    }

    public static function get():string
    {
        return self::$instance->getState();
    }

    public function getState():string
    {
        return $this->state;
    }

    public static function set($state):void
    {
        self::$instance->setState($state);
    }

    public function setState(string $state):void
    {
        $this->state = $state;
        file_put_contents($this->getFilename(), $state);
    }

    public function getFilename():string
    {
        return sprintf('%s/%s-state.json', self::DIR, User::get()->id());
    }
}