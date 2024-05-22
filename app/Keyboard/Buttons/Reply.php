<?php

namespace Ovxivan\Telegram\Keyboard\Buttons;

class Reply
{
    public function __construct(private string $text)
    {

    }

    public function render():array
    {
        return ['text'=>$this->text];
    }
}