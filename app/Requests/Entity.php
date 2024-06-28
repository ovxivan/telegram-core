<?php

namespace Ovxivan\Telegram\Requests;

abstract class Entity
{
    public static array $instance = [];
    protected array $avail = [];
    protected array $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    abstract public static function make(Update $update): static;

    public static function get(): static
    {
        return self::$instance[static::class];
    }

    protected static function init($data): static
    {
        self::$instance[static::class] = new static($data);
        return self::$instance[static::class];
    }

    public function __call($method, $arguments)
    {
        if (!array_key_exists($method, $this->avail)) {
            throw new \Exception('Неизвестный метод '.__CLASS__.'::'.$method.'()');
        }

        $key = $this->avail[$method];
        return !array_key_exists($key, $this->data) ? '' : $this->data[$key];
    }

    public function getData(): array
    {
        return $this->data;
    }
}