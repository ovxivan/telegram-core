<?php

namespace Ovxivan\Telegram\Entities\Photo;

class Image
{
    public function __construct(private string $path)
    {

    }
    public const NAME = 'photo';

    public function render()
    {
        return new \CURLFile(realpath($this->path));
    }
}