<?php

namespace Ovxivan\Telegram\Entities\Photo;

class ImageCache
{
    public const NAME='photo';

    public function __construct(private string $file_id)
    {

    }

    public function render():string
    {
        return $this->file_id;
    }
}