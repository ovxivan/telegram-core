<?php

namespace Ovxivan\Telegram\Entities\Text;

class Text
{
    const NAME = 'text';
    public function __construct(private string $text)
    {

    }

    public function render()
    {
        return $this->text;
    }
}