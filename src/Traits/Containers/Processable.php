<?php

namespace Helldar\LaravelLangPublisher\Traits\Containers;

use Helldar\LaravelLangPublisher\Contracts\Pathable as PathContract;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Illuminate\Container\Container;

trait Processable
{
    /** @var string */
    protected $processor;

    protected function getProcessor(): Processor
    {
        return $this->makeProcessor($this->processor, $this->getPath());
    }

    protected function makeProcessor(string $processor, PathContract $path = null): Processor
    {
        $path = $path ?: $this->getPath();

        return Container::getInstance()->make($processor, compact('path'));
    }
}
