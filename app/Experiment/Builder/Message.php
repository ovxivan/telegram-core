<?php

namespace Ovxivan\Telegram\Experiment\Builder;

/**
 * @method self chat(int $chat_id)
 * @method self text(string $text)
 * @method self keyboard(Keyboard $keyboard)
 */
class Message extends Builder
{
    protected array $allowed = [
        'chat'=>'chat_id',
        'text'=>'text',
        'keyboard'=>'reply_markup',
    ];
}