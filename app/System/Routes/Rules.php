<?php

namespace Ovxivan\Telegram\System\Routes;

use Ovxivan\Telegram\Controllers\MainController;
use Ovxivan\Telegram\Controllers\MessageController;
use Ovxivan\Telegram\Controllers\ProductController;
use Ovxivan\Telegram\Controllers\RegisterController;
use Ovxivan\Telegram\Controllers\WowController;
use Ovxivan\Telegram\System\Router;

class Rules
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle(): void
    {
        $this->setRules($this->router);
    }

    protected function setRules(Router &$router): void
    {
        $router->text()->strong('/message-list', [MessageController::class, 'index']);
        $router->text()->strong('/message',  [MessageController::class, 'send']);
        $router->callbackQuery()->strong('editedit', [MessageController::class, 'edit']);
        $router->callbackQuery()
            ->state('register_step_one')
            ->regex('(ru|uz)', [RegisterController::class, 'stepOne']);
        $router->state('register_step_two')->contact([RegisterController::class, 'stepTwo']);
        $router->state('register_step_three')->location([RegisterController::class, 'stepThree']);

        $router->text()->strong('/start', [MainController::class, 'start']);
        $router->callbackQuery()->regex('\d+', [WowController::class, 'number']);
        $router->callbackQuery()->regex('wow\s\d{2}\.\d{2}\.\d{4}', [WowController::class, 'index']);
        $router->text()->strong('😂😂😂 Супер большая кнопка 😂😂😂', [MainController::class, 'bigButton']);
        $router->text()->strong('Товары', [ProductController::class, 'index']);
        $router->callbackQuery()->regex('minus\s(\-?\d+)', [ProductController::class, 'minus']);
        $router->callbackQuery()->regex('plus\s(\d+)', [ProductController::class, 'plus']);

        $router->text()->strong('Сообщения', [MessageController::class, 'index']);
        $router->callbackQuery()->regex('message\_remove\_(\d+)', [MessageController::class, 'remove']);
    }
}