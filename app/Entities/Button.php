<?php

namespace Ovxivan\Telegram\Entities;

/**
 * @method self text(string $text)
 * @method self data(string $data)
 * @method self requestContact()
 * @method self requestLocation(bool $flag)
 * @method self url(string $url)
 */
class Button extends Builder
{
    protected array $allowed = [
        'text'=>'text',
        'data'=>'callback_data',
        'requestContact'=>'request_contact',
        'requestLocation'=>'request_location',
    ];
}