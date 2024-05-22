<?php

namespace Ovxivan\Telegram\Keyboard;

class Keyboard
{
    const NAME  = 'reply_markup';
    public array $rows;
    const TYPE_REPLY = [
        'id' => 'reply',
        'value' => 'keyboard'
    ];
    const TYPE_INLINE = [
        'id' => 'inline',
        'value' => 'inline_keyboard'
    ];

    public function __construct(private string $type)
    {

    }

    public function add(KeyboardRow $row)
    {
        $this->rows[] = $row;
        return $this;
    }

    public function render(): string
    {
        $result = [];
        foreach ($this->rows as $row) {
            $result[] = $row->render();
        }
        return json_encode([
            $this->getType() => $result
        ]);
    }

    private function getType(): string
    {
        return match ($this->type) {
            self::TYPE_REPLY['id'] => self::TYPE_REPLY['value'],
            self::TYPE_INLINE['id'] => self::TYPE_INLINE['value'],
        };
    }
}