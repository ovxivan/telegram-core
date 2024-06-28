<?php

namespace Ovxivan\Telegram\Requests;


/**
 *
 * @method array location()
 * @method integer id()
 * @method array contact()
 * @method array from()
 * @method string text()
 */
class Message extends Entity
{
    protected array $avail = [
        'id' => 'message_id',
        'location' => 'location',
        'contact' => 'contact',
        'text' => 'text',
        'from' => 'from',
    ];

    public static function make(Update $update): static
    {
        $data = [];
        if ($update->isTextMessage()) {
            $data = $update->getData()['message'];
        } elseif ($update->isCallback()) {
            $data = CallbackQuery::get()->message();
        }
        return self::init($data);
    }
}