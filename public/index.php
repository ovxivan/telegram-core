<?php

include '../vendor/autoload.php';

use Ovxivan\Telegram\System\Bot;
use Ovxivan\Telegram\Requests\Update;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\Requests\CallbackQuery;
use Ovxivan\Telegram\Requests\Message;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

Bot::make(getenv('BOT_TOKEN'));
$router = new \Ovxivan\Telegram\System\Router();

Bot::get()->getUpdates(function ($item) use ($router) {
    print_r([
        'update_is_coming' => true,
        'time' => microtime(true),
    ]);
    $update = Update::make($item);
    Chat::makeFromUpdate($update);
    CallbackQuery::makeFromUpdate($update);
    Message::makeFromUpdate($update);
    $router->text()->strong('/start', [\Ovxivan\Telegram\Controllers\MainController::class, 'start']);
    $router->callbackQuery()->regex('\d+', [\Ovxivan\Telegram\Controllers\WowController::class, 'number']);
    $router->callbackQuery()->regex('wow\s\d{2}\.\d{2}\.\d{4}', [\Ovxivan\Telegram\Controllers\WowController::class, 'index']);
    $router->text()->strong('😂😂😂 Супер большая кнопка 😂😂😂', [\Ovxivan\Telegram\Controllers\MainController::class, 'bigButton']);
    $router->text()->strong('Товары', [\Ovxivan\Telegram\Controllers\ProductController::class, 'index']);
    $router->callbackQuery()->regex('minus\s(\-?\d+)', [\Ovxivan\Telegram\Controllers\ProductController::class, 'minus']);
    $router->callbackQuery()->regex('plus\s(\d+)', [\Ovxivan\Telegram\Controllers\ProductController::class, 'plus']);

}, 1000000);


