<?php

namespace Ovxivan\Telegram\Entities\All;

use Ovxivan\Telegram\Requests\CallbackQuery;

class AnswerCallBackQuery
{
    const NAME = 'callback_query_id';
    public function render():int
    {
        return CallbackQuery::get()->id();
    }
}