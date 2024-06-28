<?php

namespace Ovxivan\Telegram\Entities;

use Ovxivan\Telegram\Entities\Interfaces\Editable;
use Ovxivan\Telegram\Requests\CallbackQuery;
use Ovxivan\Telegram\Requests\Chat;

/**
 * @method self chat(int $chat_id)
 * @method self text(string $text)
 * @method self keyboard(Keyboard $keyboard)
 * @method self callback(int $callback_query_id)
 * @method self setId(int $id)
 * @method self photo(string $photo)
 */
class Message extends Builder implements Editable
{
    protected array $allowed = [
        'chat'=>'chat_id',
        'text'=>'text',
        'keyboard'=>'reply_markup',
        'callback'=>'callback_query_id',
        'setId'=>'message_id',
        'photo'=>'photo',
    ];

    public function edit():self
    {
        $this->setCallbackQueryId();
        $this->chat(Chat::get()->id());
        $this->setId(\Ovxivan\Telegram\Requests\Message::get()->id());
        return $this;
    }

    public function setCallbackQueryId():self
    {
        $this->callback(CallbackQuery::get()->id());
        return $this;
    }
}