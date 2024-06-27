<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\Entities\All\Receiver;
use Ovxivan\Telegram\Entities\Photo\ImageCache;
use Ovxivan\Telegram\Experiment\Builder\Button;
use Ovxivan\Telegram\Experiment\Builder\Keyboard;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\System\Bot;
use Ovxivan\Telegram\Experiment\Builder\Message;

class ProductController
{
    const IPHONE = 'AgACAgIAAxkDAAIB7WZNyJUg17eMGKR_xONkQdTntPziAAJa3TEbFF9pSqATIQeWXkeRAQADAgADbQADNQQ';

    public function index(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $message = (new Message())
                ->chat(Chat::get()->id())
                ->photo(self::IPHONE)
                ->keyboard(
                    (new Keyboard())->inline()
                    ->add((new Button())->text('-')->data('minus 0'))
                    ->add((new Button())->text(0)->data('0'))
                    ->add((new Button())->text('+')->data('plus 1'))
                );
            Bot::get()->sendPhoto($message);
        }
    }

    public function minus($value): void
    {
        $message = new \Ovxivan\Telegram\Experiment\Builder\Message();
        if ($value <= -1) {
            $message
                ->setCallbackQueryId()
                ->text('Кол-во не должно быть меньше нуля');
            Bot::get()->answer($message);
            die;
        }

        if ($value >= 0) {
            $message
                ->keyboard(
                (new Keyboard())->inline()
                    ->add(
                        (new Button())->data('minus '.$value - 1)->text('-')
                    )
                    ->add(
                        (new Button())->data($value)->text($value)
                    )
                    ->add(
                        (new Button())->data('minus '.$value + 1)->text('+')
                    )
            );
            $result = Bot::get()->editCaption($message);
        }
    }

    public function plus($value): void
    {
        $message = (new Message());
        $message->keyboard(
            (new \Ovxivan\Telegram\Experiment\Builder\Keyboard())->inline()
                ->add(
                    (new Button())->data('minus '.$value - 1)->text('-')
                )
                ->add(
                    (new Button())->data($value)->text($value)
                )
                ->add(
                    (new Button())->data('minus '.$value + 1)->text('+')
                )
        );
        Bot::get()->editCaption($message);
    }
}