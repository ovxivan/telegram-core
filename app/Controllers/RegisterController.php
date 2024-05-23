<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\Entities\All\AnswerCallBackQuery;
use Ovxivan\Telegram\Entities\All\Message;
use Ovxivan\Telegram\Entities\All\Receiver;
use Ovxivan\Telegram\Entities\Text\Text;
use Ovxivan\Telegram\Keyboard\Buttons\Inline;
use Ovxivan\Telegram\Keyboard\Buttons\Reply;
use Ovxivan\Telegram\Keyboard\Keyboard;
use Ovxivan\Telegram\Keyboard\KeyboardRow;
use Ovxivan\Telegram\Requests\User;
use Ovxivan\Telegram\System\Bot;
use Ovxivan\Telegram\System\Router;
use Ovxivan\Telegram\System\State;

class RegisterController
{
    public function stepOne(string $lang): void
    {
        State::set('register_step_two');
        $message = new Message();
        $message->add(
            new Receiver(User::get()->id())
        )
            ->add(
                new Text('Круто, теперь осталось поделиться своим телефоном!')
            )
            ->add(
                (new Keyboard('reply'))
                    ->add(
                        (new KeyboardRow())
                            ->add(
                                (new Reply('Отправить свой номер'))->requestContact()
                            )
                    )
            );
        Bot::get()->send($message);
    }

    public function stepTwo($contact): void
    {
        State::set('register_step_three');
        $message = new Message();
        $message->add(
            new Receiver(User::get()->id())
        )
            ->add(
                new Text('
                Вас зовут: '.$contact['first_name'].'
                Ваш номер: '.$contact['phone_number'].'
                
                Теперь отправьте мне свое местоположение!')
            )
            ->add(
                (new Keyboard('reply'))
                    ->add(
                        (new KeyboardRow())
                            ->add(
                                (new Reply('Расшарить локацию'))->requestLocation()
                            )
                    )
            );
        Bot::get()->send($message);
    }

    public function stepThree($location){
        $message = new Message();
        $message->add(
            new Receiver(User::get()->id())
        )->add(
            new Text('Вы успешно прошли процедуру регистрации
Ваши гео данные: '.json_encode($location))
        );
        Bot::get()->send($message);
        State::set('work');
        Router::get()->setCurrentState('work')->go([MainController::class, 'start']);
    }
}