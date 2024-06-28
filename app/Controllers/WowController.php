<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\Entities\Message;
use Ovxivan\Telegram\Requests\CallbackQuery;
use Ovxivan\Telegram\Requests\User;
use Ovxivan\Telegram\System\Bot;

class WowController
{
    public function index(): void
    {
        $message = (new Message())
            ->setCallbackQueryId()
            ->text('Вы нажали на кнопку '.CallbackQuery::get()->data()."\n И получи еще сообщение");
        Bot::get()->answer($message);

        $message = (new Message())
            ->chat(User::get()->id())
            ->text('Тут какойто дополнительный текст =)');
        Bot::get()->send($message);
    }

    public function number(): void
    {
        $message = (new Message())
            ->setCallbackQueryId()
            ->text('Вы нажали на кнопку '.CallbackQuery::get()->data());
        Bot::get()->answer($message);
    }
}