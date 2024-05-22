<?php

namespace Ovxivan\Telegram\System;

class Benchmark
{
    private float $start;
    public function setStart():void
    {
        $this->start = microtime(true);
    }

    public function result():float
    {
        return microtime(true) - $this->start;
    }
}