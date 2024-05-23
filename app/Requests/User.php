<?php

namespace Ovxivan\Telegram\Requests;

class User
{
    private static self|null $instance;

    public function __construct(private array $data)
    {

    }
    public static function make(Update $update):self
    {
        if ($update->isCallback()){
            $data = $update->getData()['callback_query']['from'];
        } else{
            $data = $update->getData()['message']['from'];
        }
        self::$instance = new self($data);
        return self::$instance;
    }

    public static function get():self
    {
        return self::$instance;
    }

    public function id()
    {
        return $this->data['id'];
    }
}