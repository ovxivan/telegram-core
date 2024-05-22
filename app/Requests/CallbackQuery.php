<?php

namespace Ovxivan\Telegram\Requests;

use http\Exception\InvalidArgumentException;

class CallbackQuery
{
    private array $data = [
        'data'=>'',
    ];
    private static null|self $instance;

    public static function makeFromUpdate(Update $update):self
    {
        self::$instance = new self;
        if ($update->isCallback()){
            self::$instance->setData($update->getData()['callback_query']);
        }
        return self::$instance;
    }

    public function setData(array $data):self
    {
        $this->data = $data;
        return $this;
    }

    public static function get():self
    {
        return self::$instance;
    }

    public function data():string
    {
        return $this->data['data'];
    }

    public function id()
    {
        return $this->data['id'];
    }

    public function message():array
    {
        return $this->data['message'];
    }
}