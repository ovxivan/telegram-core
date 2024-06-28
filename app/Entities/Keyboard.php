<?php

namespace Ovxivan\Telegram\Entities;

/**
 * @method self persistent(bool $flag)
 * @method self resize(bool $flag)
 * @method self oneTime(bool $flag)
 */
class Keyboard extends Builder
{
    private string $type = 'keyboard';
    protected array $allowed = [
        'persistent'=>'is_persistent',
        'resize'=>'resize_keyboard',
        'onetime'=>'one_time_keyboard',
    ];
    protected array $keyboard = [0=>[]];
    private int $row = 0;
    public function add(Button $button):self
    {
        $this->keyboard[$this->row][] = $button->render();
        return $this;
    }

    public function addRow():self
    {
        $this->row++;
        return $this;
    }

    public function inline():self
    {
        $this->type = 'inline_keyboard';
        return $this;
    }

    public function reply():self
    {
        $this->type = 'keyboard';
        return $this;
    }

    public function render():mixed
    {
        $this->data[$this->type] = $this->keyboard;
        return json_encode($this->data);
    }
}