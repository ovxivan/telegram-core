<?php

include '../vendor/autoload.php';

use Ovxivan\Telegram\System\Bot;
use Dotenv\Dotenv;
use Ovxivan\Telegram\System\App;

$dotenv = Dotenv::createImmutable(realpath('../'));
$dotenv->load();

Bot::make($_ENV['BOT_TOKEN']);
Bot::get()->getUpdates(function ($item){
    App::make($item);
});


