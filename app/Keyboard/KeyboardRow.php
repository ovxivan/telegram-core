<?php

namespace Ovxivan\Telegram\Keyboard;

class KeyboardRow
{
    private array $buttons;
    public function add($button)
    {
        $this->buttons[] = $button;
        return $this;
    }

    public function render():array
    {
        $result = [];
        foreach($this->buttons as $button){
            $result[] = $button->render();
        }
        return $result;
    }
}