<?php

namespace Ovxivan\Telegram\Experiment\Builder;


use Ovxivan\Telegram\Entities\Interfaces\Renderable;

class Builder implements Renderable
{
    protected array $allowed = [];
    protected array $data = [];

    public function __call($name, $argument):self
    {
        if (!array_key_exists($name, $this->allowed)) throw new \Exception('Неверный метод ' . $name);
        $this->data[$this->allowed[$name]] = $argument[0];
        return $this;
    }

    public function render(): mixed
    {
        $result = [];
        foreach($this->data as $key=>$value){
            $value = is_object($value) ? $value->render() : $value;
            $result[$key] = $value;
        }
        return $result;
    }
}