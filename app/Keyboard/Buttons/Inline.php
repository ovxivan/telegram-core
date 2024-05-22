<?php

namespace Ovxivan\Telegram\Keyboard\Buttons;

class Inline
{
    public function __construct(
        private string $text,
        private string $data
    )
    {

    }

    public function render():array
    {
        return [
            'text'=>$this->text,
            'callback_data'=>$this->data,
        ];
    }
}