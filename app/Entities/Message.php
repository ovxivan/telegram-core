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
 * @method self parseMode(string $mode)
 * @method self linkOptions(string $options)
 * @method self threadId(integer $id)
 * @method self disableNotification(bool $flag)
 * @method self protectContent(bool $flag)
 */
class Message extends Builder implements Editable
{
    const PARSE_MODE_MARKDOWN2 = 'MarkdownV2';
    const PARSE_MODE_HTML = 'HTML';
    public function __construct()
    {
        $this->markDownV2();
    }
    protected array $allowed = [
        'chat'=>'chat_id',
        'text'=>'text',
        'keyboard'=>'reply_markup',
        'callback'=>'callback_query_id',
        'setId'=>'message_id',
        'photo'=>'photo',
        'parseMode'=>'parse_mode',
        'linkOptions'=>'link_preview_options',
        'threadId'=>'message_thread_id',
        'disableNotification'=>'disable_notification',
        'protectContent'=>'protect_content',
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

    public function markDownV2():self
    {
        $this->parseMode(self::PARSE_MODE_MARKDOWN2);
        return $this;
    }

    public function html():self
    {
        $this->parseMode(self::PARSE_MODE_HTML);
        return $this;
    }

    public function preview(
        $url,
        $large = false,
        $text_after=false
    ):self
    {
        $this->linkOptions(json_encode([
            'is_disabled' => false,
            'url'=>$url,
            'prefer_small_media'=>!$large,
            'prefer_large_media'=>$large,
            'show_above_text'=>$text_after,
        ]));
        return $this;
    }

    public function notificationOff():self
    {
        $this->disableNotification(true);
        return $this;
    }

    public function enableProtect():self
    {
        $this->protectContent(true);
        return $this;
    }
}