<?php

namespace Ovxivan\Telegram\Requests;

/**
 * @method integer id()
 * @method string firstName()
 * @method string lastName()
 * @method string username()
 * @method string language()
 * @method bool isBot()
 */
class User extends Entity
{
    protected array $avail = [
        'id'=>'id',
        'firstName'=>'first_name',
        'lastName'=>'last_name',
        'username'=>'username',
        'language'=>'language_code',
        'isBot'=>'is_bot',
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