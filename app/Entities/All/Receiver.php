<?php

namespace Ovxivan\Telegram\Entities\All;

class Receiver
{
    const NAME = 'chat_id';
    public function __construct(private int $chatId)
    {

    }

    public function render()
    {
        return $this->chatId;
    }
}