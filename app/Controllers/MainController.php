<?php

namespace Ovxivan\Telegram\Controllers;

use Ovxivan\Telegram\Entities\Button;
use Ovxivan\Telegram\Entities\Keyboard;
use Ovxivan\Telegram\Entities\Message;
use Ovxivan\Telegram\Requests\Chat;
use Ovxivan\Telegram\Requests\User;
use Ovxivan\Telegram\System\Bot;
use Ovxivan\Telegram\System\State;

class MainController
{
    public function start(): void
    {
        $message = (new Message())
            ->chat(Chat::get()->id());
        if (State::isDefault()) {
            State::set('register_step_one');
            $message->text('Добро пожаловать в мой бот. Для начала выбери язык')
                ->keyboard(
                    (new Keyboard())->inline()
                        ->add((new Button())->data('uz')->text('Узбекский'))
                        ->add((new Button())->data('ru')->text('Русский'))
                );
            Bot::get()->send($message);
        } else {
            $message
                ->text("Привет друг!\nПоздравляю тебя с успешным прохождением регистрации!")
                ->keyboard(
                    (new Keyboard())
                        ->resize(false)
                        ->add((new Button())->text('😂😂😂 Супер большая кнопка 😂😂😂'))
                        ->addRow()
                        ->add((new Button())->text('Товары'))
                );
            Bot::get()->send($message);

            $message = (new Message())
                ->chat(Chat::get()->id())
                ->text('Это текст с клавиатурой inline + ваши данные: '.json_encode([
                        'first_name' => User::get()->firstName(),
                        'last_name' => User::get()->lastName(),
                        'username' => User::get()->username(),
                        'isBot' => User::get()->isBot(),
                        'language' => User::get()->language(),
                    ]))
                ->keyboard(
                    (new Keyboard())->inline()
                        ->add((new Button())->text('01')->data('01'))
                        ->add((new Button())->text('02')->data('02'))
                        ->add((new Button())->text('03')->data('03'))
                        ->add((new Button())->text('08')->data('08'))
                        ->addRow()
                        ->add((new Button())->text('04')->data('04'))
                        ->add((new Button())->text('05')->data('05'))
                        ->add((new Button())->text('06')->data('06'))
                        ->addRow()
                        ->add((new Button())->text('Кнопка WOW 😉')->data('wow '.date('d.m.Y')))
                );
            Bot::get()->send($message);
        }
    }

    public function bigButton(): void
    {

        $message = (new Message())
            ->chat(User::get()->id())
            ->text('Не ну ты красава! 😂😂😂')
            ->keyboard(
                (new Keyboard())
                    ->add((new Button())->text('😂😂😂 Супер большая кнопка 😂😂😂'))
                    ->add((new Button())->text('/start'))
            );
        Bot::get()->send($message);
    }

    public function parseModeHtml(): void
    {
        Bot::get()->send(
            (new Message())
                ->html()
                ->text($this->getHtmlText())
                ->chat(User::get()->id())
        );
    }

    public function getHtmlText(): string
    {
        return <<<HTML
<b>bold</b>, <strong>bold</strong>
<i>italic</i>, <em>italic</em>
<u>underline</u>, <ins>underline</ins>
<s>strikethrough</s>, <strike>strikethrough</strike>, <del>strikethrough</del>
<span class="tg-spoiler">spoiler</span>, <tg-spoiler>spoiler</tg-spoiler>
<b>bold <i>italic bold <s>italic bold strikethrough <span class="tg-spoiler">italic bold strikethrough spoiler</span></s> <u>underline italic bold</u></i> bold</b>
<a href="http://www.example.com/">inline URL</a>
<a href="tg://user?id=123456789">inline mention of a user</a>
<tg-emoji emoji-id="5368324170671202286">👍</tg-emoji>
<code>inline fixed-width code</code>
<pre>pre-formatted fixed-width code block</pre>
<pre><code class="language-python">pre-formatted fixed-width code block written in the Python programming language</code></pre>
<blockquote>Block quotation started\nBlock quotation continued\nThe last line of the block quotation</blockquote>
<blockquote expandable>Expandable block quotation started\nExpandable block quotation continued\nExpandable block quotation continued\nHidden by default part of the block quotation started\nExpandable block quotation continued\nThe last line of the block quotation</blockquote>
HTML;

    }

    public function parseModeMarkdownV2(): void
    {
        Bot::get()->send(
            (new Message())
                ->text($this->getMarkdownV2Text())
                ->chat(User::get()->id())
        );
    }

    private function getMarkdownV2Text(): string
    {
        return '*bold \*text*
_italic \*text_
__underline__
~strikethrough~
||spoiler||
*bold _italic bold ~italic bold strikethrough ||italic bold strikethrough spoiler||~ __underline italic bold___ bold*
[inline URL](http://www.example.com/)
[inline mention of a user](tg://user?id=123456789)
![👍](tg://emoji?id=5368324170671202286)
`inline fixed-width code`
```
pre-formatted fixed-width code block
```
```python
pre-formatted fixed-width code block written in the Python programming language
```
>Block quotation started
>Block quotation continued
>Block quotation continued
>Block quotation continued
>The last line of the block quotation
**>The expandable block quotation started right after the previous block quotation
>It is separated from the previous block quotation by an empty bold entity
>Expandable block quotation continued
>Hidden by default part of the expandable block quotation started
>Expandable block quotation continued
>The last line of the expandable block quotation with the expandability mark||';
    }

    public function linkPreviewOptions(): void
    {
        $result = Bot::get()->send(
            (new Message())
                ->chat(User::get()->id())
                ->text('Тестовый текст')
                ->preview(
                    'https://ya.ru',
                    large: false,
                    text_after: true
                )
        );
    }

    public function protect(): void
    {
        $result = Bot::get()->send(
            (new Message())
                ->chat(User::get()->id())
                ->text($this->getMarkdownV2Text())
                ->notificationOff()
                ->enableProtect()
        );
    }

    public function notificationOff(): void
    {
        $result = Bot::get()->send(
            (new Message())
                ->chat(User::get()->id())
                ->text($this->getMarkdownV2Text())
                ->notificationOff()
        );
    }
}