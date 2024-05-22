<?php

namespace Ovxivan\Telegram\Requests;

class Chat
{
    private array $data;
    private static $instance;
    public static function makeFromUpdate(Update $update)
    {
        $chat = new self;
        if ($update->isCallback()){
            $data = $update->getData()['callback_query']['message']['chat'];
        } else{
            $data = $update->getData()['message']['chat'];
        }
        $chat->setData($data);
        self::$instance = $chat;
    }

    public function setData($data):void
    {
        $this->data = $data;
    }
    public static function get():self
    {
        return self::$instance;
    }

    public function id():int
    {
        return $this->data['id'];
    }
}