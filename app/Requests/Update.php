<?php

namespace Ovxivan\Telegram\Requests;

class Update
{
    private static null|self $instance;
    public function __construct(private array $update)
    {

    }

    public static function make($update):self
    {
        self::$instance = new self($update);
        return self::$instance;
    }

    public static function get():self
    {
        return self::$instance;
    }

    public function isCallback():bool
    {
        return !empty($this->update['callback_query']);
    }

    public function isTextMessage():bool
    {
        return !$this->isCallback();
    }

    public function getData()
    {
        return $this->update;
    }
}