<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\Entities\All\Message;
use Ovxivan\Telegram\Entities\All\Receiver;
use Ovxivan\Telegram\Entities\Text\Text;
use Ovxivan\Telegram\Experiment\Builder\Button;
use Ovxivan\Telegram\Keyboard\Buttons\Inline;
use Ovxivan\Telegram\Keyboard\Buttons\Reply;
use Ovxivan\Telegram\Keyboard\Keyboard;
use Ovxivan\Telegram\Keyboard\KeyboardRow;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\System\Benchmark;
use Ovxivan\Telegram\System\Bot;
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
            $message = (new \Ovxivan\Telegram\Experiment\Builder\Message())
                ->chat(Chat::get()->id())
                ->text("Привет друг!\nПоздравляю тебя с успешным прохождением регистрации!")
                ->keyboard(
                    (new \Ovxivan\Telegram\Experiment\Builder\Keyboard())
                        ->resize(false)
                        ->add(
                            (new Button())->text('😂😂😂 Супер большая кнопка 😂😂😂')
                        )
                        ->addRow()
                        ->add(
                            (new Button())->text('Товары')
                        )
                );
            $render = $message->render();
            $result = Bot::get()->send($message);

            $message = (new \Ovxivan\Telegram\Experiment\Builder\Message())
                ->chat(Chat::get()->id())
                ->text('Это текст с клавиатурой inline')
                ->keyboard(
                    (new \Ovxivan\Telegram\Experiment\Builder\Keyboard())->inline()
                        ->add(
                            (new Button())->text('01')->data('01')
                        )
                        ->add(
                            (new Button())->text('02')->data('02')
                        )
                        ->add(
                            (new Button())->text('03')->data('03')
                        )
                        ->addRow()
                        ->add(
                            (new Button())->text('04')->data('04')
                        )
                        ->add(
                            (new Button())->text('05')->data('05')
                        )
                        ->add(
                            (new Button())->text('06')->data('06')
                        )
                        ->addRow()
                        ->add(
                            (new Button())->text('Кнопка WOW 😉')->data('wow '.date('d.m.Y'))
                        )
                );
            $render = $message->render();
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