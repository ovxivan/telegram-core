<?php

namespace Ovxivan\Telegram\Requests;


class Message
{
    private static $instance;
    private array $data = [
        'text'=>'',
    ];

    public static function makeFromUpdate(Update $update):void
    {
        self::$instance = new Message();
        if ($update->isTextMessage()){
            self::$instance->setData($update->getData()['message']);
        } elseif ($update->isCallback()){
            self::$instance->setData(CallbackQuery::get()->message());
        }
    }

    public static function get():self
    {
        return self::$instance;
    }

    public function setData($data):void
    {
        $this->data = array_merge($this->data, $data);
    }

    public function text()
    {
        return $this->data['text'];
    }

    public function id()
    {
        return $this->data['message_id'];
    }
}