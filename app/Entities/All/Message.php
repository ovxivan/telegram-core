<?php

namespace Ovxivan\Telegram\Entities\All;

use Ovxivan\Telegram\Requests\CallbackQuery;
use Ovxivan\Telegram\Requests\Chat;
use \Ovxivan\Telegram\Requests\Message as RequestMessage;

class Message
{
    private array $items;
    private bool $is_edit = false;

    public function add($item)
    {
        $this->items[] = $item;
        return $this;
    }

    public function edit()
    {
        $this->is_edit = true;
    }

    public function render():array
    {
        $result = [];
        foreach($this->items as $item){
            $result[$item::NAME] = $item->render();
        }

        if ($this->is_edit){
            $result['message_id'] = RequestMessage::get()->id();
            $result['callback_query_id'] = CallbackQuery::get()->id();
            $result['chat_id'] = Chat::get()->id();
        }
        return $result;
    }
}