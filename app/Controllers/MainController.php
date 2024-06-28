<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\Entities\Button;
use Ovxivan\Telegram\Entities\Keyboard;
use Ovxivan\Telegram\Entities\Message;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\Requests\User;
use Ovxivan\Telegram\System\Bot;
use Ovxivan\Telegram\System\State;

class MainController
{
    public function start(): void
    {
        $message = (new Message())
            ->chat(Chat::get()->id());
        if (State::isDefault()) {
            State::set('register_step_one');
            $message->text('Добро пожаловать в мой бот. Для начала выбери язык')
                ->keyboard(
                    (new Keyboard())->inline()
                        ->add((new Button())->data('uz')->text('Узбекский'))
                        ->add((new Button())->data('ru')->text('Русский'))
                );
            Bot::get()->send($message);
        } else {
            $message
                ->text("Привет друг!\nПоздравляю тебя с успешным прохождением регистрации!")
                ->keyboard(
                    (new Keyboard())
                        ->resize(false)
                        ->add((new Button())->text('😂😂😂 Супер большая кнопка 😂😂😂'))
                        ->addRow()
                        ->add((new Button())->text('Товары'))
                );
            Bot::get()->send($message);

            $message = (new Message())
                ->chat(Chat::get()->id())
                ->text('Это текст с клавиатурой inline')
                ->keyboard(
                    (new Keyboard())->inline()
                        ->add((new Button())->text('01')->data('01'))
                        ->add((new Button())->text('02')->data('02'))
                        ->add((new Button())->text('03')->data('03'))
                        ->add((new Button())->text('08')->data('08'))
                        ->addRow()
                        ->add((new Button())->text('04')->data('04'))
                        ->add((new Button())->text('05')->data('05'))
                        ->add((new Button())->text('06')->data('06'))
                        ->addRow()
                        ->add((new Button())->text('Кнопка WOW 😉')->data('wow '.date('d.m.Y')))
                );
            Bot::get()->send($message);
        }
    }

    public function bigButton(): void
    {

        $message = (new Message())
            ->chat(User::get()->id())
            ->text('Не ну ты красава! 😂😂😂')
            ->keyboard(
                (new Keyboard())
                    ->add((new Button())->text('😂😂😂 Супер большая кнопка 😂😂😂'))
                    ->add((new Button())->text('/start'))
            );
        Bot::get()->send($message);
    }
}