<?php

include '../vendor/autoload.php';

use \Ovxivan\Telegram\Transport\Bot;
use Ovxivan\Telegram\Receiver;
use Ovxivan\Telegram\Message;
use Ovxivan\Telegram\Image;
use Ovxivan\Telegram\Caption;

$chat_id = 2082821074;
//$chat_id  = '@ovxivan';
$image = './product.jpg';

Bot::make('7182755753:AAEknj5Vdsy5yZMlOcPtVyTY-m8WdwrzEKI');
$message = new Message();
$message->add(
    new Receiver($chat_id)
)
    ->add(
        new Image($image)
    )
    ->add(
        new Caption('Iphone Pro Max')
    );
$result = Bot::get()->sendPhoto($message);

print_r([
    'result'=>$result,
    'message'=>$message->render(),
]);