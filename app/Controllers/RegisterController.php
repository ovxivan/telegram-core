<?php

namespace Ovxivan\Telegram\Controllers;


use Ovxivan\Telegram\Entities\Button;
use Ovxivan\Telegram\Entities\Keyboard;
use Ovxivan\Telegram\Entities\Message;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\Requests\User;
use Ovxivan\Telegram\System\Bot;
use Ovxivan\Telegram\System\Router;
use Ovxivan\Telegram\System\State;

class RegisterController
{
    public function stepOne(string $lang): void
    {
        State::set('register_step_two');
        $message = (new Message())
            ->chat(User::get()->id())
            ->text('Круто, теперь осталось поделиться своим телефоном!')
            ->keyboard(
                (new Keyboard())
                    ->add((new Button())->text('Отправить свой номер')->requestContact())
            );
        Bot::get()->send($message);
    }

    public function stepTwo($contact): void
    {
        State::set('register_step_three');
        $message = (new Message())
            ->chat(Chat::get()->id())
            ->text('
                Вас зовут: '.$contact['first_name'].'
                Ваш номер: '.$contact['phone_number'].'
                
                Теперь отправьте мне свое местоположение!')
            ->keyboard(
                (new Keyboard())
                    ->add((new Button())->requestContact()->text('Расшарить локацию'))
            );
        Bot::get()->send($message);
    }

    public function stepThree($location)
    {
        $message = (new Message())
            ->chat(Chat::get()->id())
            ->text('Вы успешно прошли процедуру регистрации
Ваши гео данные: '.json_encode($location));
        Bot::get()->send($message);
        State::set('work');
        Router::get()->setCurrentState('work')->go([MainController::class, 'start']);
    }
}