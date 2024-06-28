<?php

namespace Ovxivan\Telegram\System;

use Ovxivan\Telegram\Requests\CallbackQuery;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\Requests\Message;
use Ovxivan\Telegram\Requests\Update;
use Ovxivan\Telegram\Requests\User;
use Ovxivan\Telegram\System\Routes\Rules;

class App
{
    private array $request = [];
    private Router $router;

    private Update $update;

    private static self|null $instance = null;

    public static function make($update):self
    {
        self::$instance = new static;
        self::$instance->init($update);
        return self::$instance;
    }

    public function init(array $request):void
    {
        $this->request = $request;
        $this->initUpdate(Update::start($request));
        $this->loadRouter();
    }

    private function initUpdate(Update $update)
    {
        Chat::make($update);
        CallbackQuery::make($update);
        Message::make($update);
        User::make($update);
    }

    protected function loadRouter():void
    {
        State::make();
        $this->router = new Router;
        $this->router->setCurrentState(State::get());
        (new Rules($this->router))->handle();
    }

    public static function get():self
    {
        return self::$instance;
    }
}