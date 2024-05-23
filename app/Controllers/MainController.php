<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\System\Benchmark;
use Ovxivan\Telegram\Keyboard\Keyboard;
use Ovxivan\Telegram\Keyboard\KeyboardRow;
use Ovxivan\Telegram\Entities\All\Message;
use Ovxivan\Telegram\Entities\All\Receiver;
use Ovxivan\Telegram\Entities\Text\Text;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\Requests\Message as UpdateMessage;
use Ovxivan\Telegram\System\Bot;
use Ovxivan\Telegram\Keyboard\Buttons\Reply;
use Ovxivan\Telegram\Keyboard\Buttons\Inline;
use Ovxivan\Telegram\System\State;

class MainController
{
    public function start(): void
    {
        $message = new Message();
        $message->add(new Receiver(Chat::get()->id()));
        if (State::isDefault()) {
            State::set('register_step_one');
            $message->add(
                new Text('Добро пожаловать в мой бот. Для начала выбери язык')
            )
                ->add(
                    (new Keyboard('inline'))
                        ->add(
                            (new KeyboardRow())
                                ->add(
                                    new Inline('Узбекский', 'uz')
                                )
                                ->add(
                                    new Inline('Русский', 'ru')
                                )
                        )
                );
            Bot::get()->send($message);
        } else {
            $benchmark = new Benchmark();
            $message
                ->add(
                    new Text(
                        "Привет друг!\nПоздравляю тебя с успешным прохождением регистрации!"
                    )
                )
                ->add(
                    (new Keyboard('reply'))
                        ->add(
                            (new KeyboardRow())
                                ->add(new Reply('😂😂😂 Супер большая кнопка 😂😂😂'))
                        )
                        ->add(
                            (new KeyboardRow())
                                ->add(new Reply('Товары'))
                        )
                );

            $benchmark->setStart();
            $result = Bot::get()->send($message);

            $message = new Message();
            $message->add(
                new Receiver(Chat::get()->id())
            )
                ->add(
                    new Text('Это текст с клавиатурой inline')
                )
                ->add(
                    (new Keyboard('inline'))
                        ->add(
                            (new KeyboardRow())
                                ->add(new Inline('01', '01'))
                                ->add(new Inline('02', '02'))
                                ->add(new Inline('03', '03'))
                        )
                        ->add(
                            (new KeyboardRow())
                                ->add(new Inline('04', '04'))
                                ->add(new Inline('05', '05'))
                                ->add(new Inline('06', '06'))
                        )
                        ->add(
                            (new KeyboardRow())
                                ->add(new Inline('Кнопка WOW 😉', 'wow ' . date('d.m.Y')))
                        )
                );
            $result = Bot::get()->send($message);
        }
    }

    public function bigButton(): void
    {
        $benchmark = new Benchmark();
        $message = new Message();
        $benchmark->setStart();
        $message->add(
            new Receiver(Chat::get()->id())
        )
            ->add(
                new Text('Не ну ты красава! 😂😂😂')
            )
            ->add(
                (new Keyboard('reply'))
                    ->add(
                        (new KeyboardRow())
                            ->add(new Reply('😂😂😂 Супер большая кнопка 😂😂😂'))
                    )
                    ->add(
                        (new KeyboardRow())
                            ->add(new Reply('/start'))
                    )
            );
        $result = Bot::get()->send($message);

    }
}