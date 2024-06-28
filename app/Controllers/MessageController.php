<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\Entities\Button;
use Ovxivan\Telegram\Entities\Keyboard;
use Ovxivan\Telegram\Entities\Message;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\System\Bot;

class MessageController
{
    public function index()
    {
        for ($i = 0; $i < 5; $i++) {
            $message = (new Message())->chat(Chat::get()->id())
                ->text('Lorem ipsum dolor sit amet, consectetur adipiscing elit. '.$i)
                ->keyboard(
                    (new Keyboard())->inline()
                        ->add((new Button())->text('Удалить')->data('message_remove_'.$i))
                );
            Bot::get()->send($message);
        }
    }

    public function send()
    {
        $message = (new Message())
            ->chat(Chat::get()->id())
            ->text('Какойто текст')
            ->keyboard(
                (new Keyboard())->inline()
                    ->add(
                        (new Button())->data('editedit')->text('давай поменяем текст')
                    )
            );
        Bot::get()->send($message);
    }

    public function remove($page_id = 0)
    {
        Bot::get()->deleteMessage(
            Chat::get()->id(),
            \Ovxivan\Telegram\Requests\Message::get()->id()
        );
    }

    public function edit()
    {
        $message = (new Message())
            ->text('И текст поменяли')
            ->keyboard(
                (new Keyboard())->inline()
                    ->add(
                        (new Button())->data('editedit')->text('И клаву поменяли')
                    )
            );
        Bot::get()->edit($message);
    }
}