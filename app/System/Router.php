<?php

namespace Ovxivan\Telegram\System;

use http\Exception\InvalidArgumentException;
use Ovxivan\Telegram\Requests\Update;
use Ovxivan\Telegram\Requests\CallbackQuery;
use Ovxivan\Telegram\Requests\Message;

class Router
{
    const TYPE_TEXT = 'text';
    const TYPE_CALLBACKQUERY = 'callback_query';
    private $incoming_type = self::TYPE_TEXT;

    public function text(): self
    {
        $this->incoming_type = self::TYPE_TEXT;
        return $this;
    }

    public function callbackQuery(): self
    {
        $this->incoming_type = self::TYPE_CALLBACKQUERY;
        return $this;
    }

    public function strong($text, $callback): void
    {
        if ($this->getText() == $text) {
            $this->runCallBack($callback);
        }
    }

    private function runCallback($callback, $params = []):void
    {
        if (is_callable($callback)){
            $callback();
        } elseif (is_array($callback) && sizeof($callback) ==2) {
            if (!class_exists($callback[0])){
                throw new InvalidArgumentException('Не найден класс '.$callback[0]);
            }

            if (!method_exists($callback[0], $callback[1])){
                throw new InvalidArgumentException('Не найден метод ('.$callback[2].') в классе '.$callback[0]);
            }
            $action = $callback[1];
            (new $callback[0])->$action($params);
        }
    }

    public function regex($regex, $callback): void
    {
        if (preg_match('/^' . $regex . '$/u', $this->getText(), $matches)) {
            $this->runCallback($callback, $matches);
        }
    }

    private function getText(): string
    {
        print_r(Update::get()->getData());
        return match ($this->incoming_type) {
            self::TYPE_TEXT => Message::get()->text(),
            self::TYPE_CALLBACKQUERY => CallbackQuery::get()->data(),
            default => '',
        };
    }
}