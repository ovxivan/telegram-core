<?php

namespace Ovxivan\Telegram;

class Caption
{
    public const NAME = 'caption';

    public function __construct(private string $text)
    {

    }
    public function render():string
    {
        return $this->text;
    }
}