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

class MainController
{
    public function start():void
    {
        $benchmark = new Benchmark();
        $message = new Message();
        $message
            ->add(new Receiver(Chat::get()->id()))
            ->add(
                new Text(
                    "Привет друг!\n{Вот то что ты прислал}\n" . UpdateMessage::get()->text()
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
        print_r([
            'send_request' => true,
            'time' => microtime(true),
        ]);
        $result = Bot::get()->send($message);
        print_r([
            'request' => $message->render(),
            'response' => $result,
            'time' => microtime(true),
            'benchmark' => $benchmark->result(),
        ]);

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
        print_r([
            'request' => $message->render(),
            'response' => $result,
            'time' => microtime(true),
            'benchmark' => $benchmark->result(),
        ]);
    }

    public function bigButton():void
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
        print_r([
            'request' => $message->render(),
            'response' => $result,
            'time' => microtime(true),
            'benchmark' => $benchmark->result(),
        ]);
    }
}