<?php

namespace Ovxivan\Telegram\Requests;

/**
 * @method integer id()
 */
class Chat extends Entity
{
    protected array $avail = [
        'id'=>'id',
    ];
    public static function make(Update $update):static
    {
        if ($update->isCallback()){
            $data = $update->getData()['callback_query']['message']['chat'];
        } else{
            $data = $update->getData()['message']['chat'];
        }
        return static::init($data);
    }
}