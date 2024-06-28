<?php

namespace Ovxivan\Telegram\Requests;

/**
 * @method integer id()
 */
class User extends Entity
{
    protected array $avail = [
        'id'=>'id',
    ];
    public static function make(Update $update):static
    {
        if ($update->isCallback()) {
            $data = $update->getData()['callback_query']['from'];
        } else {
            $data = $update->getData()['message']['from'];
        }
        return static::init($data);
    }
}