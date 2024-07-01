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
    private string $incoming_type = self::TYPE_TEXT;

    private string $current_state;
    private string $rule_state;

    private bool $is_used = false;

    private static self|null $instance = null;

    public static function get():self
    {
        if (is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function go($callback)
    {
        $this->is_used = false;
        $this->runCallback($callback);
    }


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

    public function setCurrentState(string $state): self
    {
        $this->current_state = $state;
        return $this;
    }

    public function strong($text, $callback): bool
    {
        if ($this->is_used) return false;
        if ($this->getText() == $text) {
            $this->runCallBack($callback);
        }
        return true;
    }

    public function state($state)
    {
        $this->rule_state = $state;
        return $this;
    }

    public function regex($regex, $callback): bool
    {
        if ($this->is_used) return false;
        if (preg_match('/^' . $regex . '$/u', $this->getText(), $matches)) {
            array_shift($matches);
            $this->runCallback($callback, $matches);
        }
        return true;
    }

    public function contact($callback): bool
    {
        if ($this->is_used) return false;
        if (($contact = Message::get()->contact())) {
            $this->runCallback($callback, [$contact]);
        }
        return true;
    }

    public function location($callback): bool
    {
        if ($this->is_used) return false;
        if (($location = Message::get()->location())) {
            $this->runCallback($callback, [$location]);
        }
        return true;
    }

    private function runCallback($callback, $params = []): bool
    {
        if (!$this->checkState()){
            return false;
        }
        $this->is_used = true;
        if (is_callable($callback)) {
            $callback();
        } elseif (is_array($callback) && sizeof($callback) == 2) {
            if (!class_exists($callback[0])) {
                throw new \Exception('Не найден класс ' . $callback[0]);
            }

            if (!method_exists($callback[0], $callback[1])) {
                throw new \Exception('Не найден метод (' . $callback[2] . ') в классе ' . $callback[0]);
            }
            $action = $callback[1];
            (new $callback[0])->$action(...$params);
        }
        return true;
    }

    public function checkState(): bool
    {
        if ($this->current_state == 'work' || $this->current_state=='default') return true;
        return $this->current_state == $this->rule_state;
    }


    private function getText(): string
    {
        return match ($this->incoming_type) {
            self::TYPE_TEXT => Message::get()->text(),
            self::TYPE_CALLBACKQUERY => CallbackQuery::get()->data(),
            default => '',
        };
    }
}