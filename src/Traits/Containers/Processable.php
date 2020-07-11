<?php

namespace Helldar\LaravelLangPublisher\Traits\Containers;

use Helldar\LaravelLangPublisher\Contracts\Processor;

trait Processable
{
    /** @var string */
    protected $processor;

    protected function getProcessor(): Processor
    {
        $path = $this->getPath();

        return $this->container($this->processor, compact('path'));
    }
}
