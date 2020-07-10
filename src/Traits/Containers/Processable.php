<?php

namespace Helldar\LaravelLangPublisher\Traits\Containers;

use Helldar\LaravelLangPublisher\Contracts\Processor;

trait Processable
{
    /** @var \Helldar\LaravelLangPublisher\Contracts\Processor */
    protected $process_php;

    /** @var \Helldar\LaravelLangPublisher\Contracts\Processor */
    protected $process_json;

    protected function getProcessor(): Processor
    {
        return $this->isJson()
            ? $this->container($this->process_json)
            : $this->container($this->process_php);
    }
}
