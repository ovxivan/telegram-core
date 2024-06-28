<?php

namespace Ovxivan\Telegram\Requests;

/**
 *
 * @method integer id()
 * @method string data()
 * @method array message()
 */
class CallbackQuery extends Entity
{
    protected array $avail = [
        'id'=>'id',
        'message'=>'message',
        'data'=>'data',
    ];
    public static function make(Update $update):static
    {
        $data = [];
        if ($update->isCallback()) {
            $data = $update->getData()['callback_query'];
        }
        return static::init($data);
    }
}