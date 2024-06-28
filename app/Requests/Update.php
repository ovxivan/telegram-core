<?php

namespace Ovxivan\Telegram\Requests;

class Update extends Entity
{
    public static function start(array $data):static
    {
        return self::init($data);
    }

    public function isCallback():bool
    {
        return !empty($this->data['callback_query']);
    }

    public function isTextMessage():bool
    {
        return !$this->isCallback();
    }

    public static function make(Update|array $update): static
    {
        // TODO: Implement make() method.
    }
}