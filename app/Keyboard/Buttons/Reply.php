<?php

namespace Ovxivan\Telegram\Keyboard\Buttons;

class Reply
{
    private bool $request_contact = false;
    private bool $request_location = false;
    public function __construct(private string $text)
    {

    }

    public function render():array
    {
        return [
            'request_contact' => $this->request_contact,
            'request_location' => $this->request_location,
            'text'=>$this->text,
        ];
    }

    public function requestContact():self
    {
        $this->request_contact = true;
        return $this;
    }

    public function requestLocation():self
    {
        $this->request_location = true;
        return $this;
    }
}