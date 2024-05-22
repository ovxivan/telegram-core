<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\Entities\All\AnswerCallBackQuery;
use Ovxivan\Telegram\Keyboard\Buttons\Inline;
use Ovxivan\Telegram\Keyboard\Keyboard;
use Ovxivan\Telegram\Keyboard\KeyboardRow;
use Ovxivan\Telegram\Entities\All\Message;
use Ovxivan\Telegram\Entities\All\Receiver;
use Ovxivan\Telegram\Entities\Text\Text;
use Ovxivan\Telegram\System\Bot;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\System\Benchmark;
use Ovxivan\Telegram\Entities\Photo\ImageCache;

class ProductController
{
    const IPHONE = 'AgACAgIAAxkDAAIB7WZNyJUg17eMGKR_xONkQdTntPziAAJa3TEbFF9pSqATIQeWXkeRAQADAgADbQADNQQ';

    public function index():void
    {
        $benchmark = new Benchmark();
        for ($i = 0; $i < 3; $i++) {
            $message = new Message();
            $message->add(
                new Receiver(Chat::get()->id())
            )
                ->add(
                    new ImageCache(self::IPHONE)
                )
                ->add(
                    (new Keyboard('inline'))
                        ->add(
                            (new KeyboardRow())
                                ->add(
                                    new Inline('-', 'minus 0')
                                )
                                ->add(
                                    new Inline('0', 0)
                                )
                                ->add(
                                    new Inline('+', 'plus 1')
                                )
                        )
                );
            $benchmark->setStart();
            $result = Bot::get()->sendPhoto($message);
            print_r([
                'request' => $message->render(),
                'response' => $result,
                'time' => microtime(true),
                'benchmark' => $benchmark->result(),
            ]);
        }
    }

    public function minus($request):void
    {
        $message = new Message();
        $value = $request[1];
        if ($value <= -1) {
            $message->add(
                new AnswerCallBackQuery()
            )
                ->add(
                    new Text('Кол-во не должно быть меньше нуля')
                );
            Bot::get()->answer($message);
            die;
        }

        if ($value >= 0) {
            $message->add(
                new AnswerCallBackQuery()
            )
                ->add(
                    (new Keyboard('inline'))
                        ->add(
                            (new KeyboardRow())
                                ->add(
                                    new Inline('-', 'minus ' . $value - 1)
                                )
                                ->add(
                                    new Inline($value, $value)
                                )
                                ->add(
                                    new Inline('+', 'plus ' . $value + 1)
                                )
                        )
                );
            Bot::get()->editCaption($message);
        }
    }

    public function plus($request):void
    {
        $message = new Message();
        $value = $request[1];
        $message->add(
            new AnswerCallBackQuery()
        )
            ->add(
                (new Keyboard('inline'))
                    ->add(
                        (new KeyboardRow())
                            ->add(
                                new Inline('-', 'minus ' . $value - 1)
                            )
                            ->add(
                                new Inline($value, $value)
                            )
                            ->add(
                                new Inline('+', 'plus ' . $value + 1)
                            )
                    )
            );
        $result = Bot::get()->editCaption($message);
        print_r([
            'request' => $message->render(),
            'response' => $result,
            'time' => microtime(true),
        ]);
    }
}