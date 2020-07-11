<?php

namespace Helldar\LaravelLangPublisher\Traits\Containers;

use Helldar\LaravelLangPublisher\Contracts\Processor;
use Illuminate\Container\Container;

trait Processable
{
    /** @var string */
    protected $processor;

    protected function getProcessor(): Processor
    {
        $path = $this->getPath();

        return Container::getInstance()->make($this->processor, compact('path'));
    }
}
