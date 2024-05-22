<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\Entities\All\AnswerCallBackQuery;
use Ovxivan\Telegram\Entities\All\Message;
use Ovxivan\Telegram\Entities\All\Receiver;
use Ovxivan\Telegram\Entities\Text\Text;
use Ovxivan\Telegram\System\Bot;
use Ovxivan\Telegram\Requests\CallbackQuery;
use Ovxivan\Telegram\Requests\Chat;

class WowController
{
    public function index():void
    {
        $message = new Message();
        $message->add(
            new AnswerCallBackQuery()
        )
            ->add(
                new Text('Вы нажали на кнопку ' . CallbackQuery::get()->data() . "\n И получи еще сообщение")
            );
        Bot::get()->answer($message);

        $message = new Message();
        $message->add(
            new Receiver(Chat::get()->id())
        )->add(
            new Text('Тут какойто дополнительный текст =)')
        );
        Bot::get()->send($message);
    }

    public function number():void
    {
        $message = new Message();
        $message->add(
            new AnswerCallBackQuery()
        )
            ->add(
                new Text('Вы нажали на кнопку ' . CallbackQuery::get()->data())
            );
        Bot::get()->answer($message);
    }
}