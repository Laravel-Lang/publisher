<?php

namespace Helldar\LaravelLangPublisher\Traits\Containers;

use Helldar\LaravelLangPublisher\Contracts\Pathable as PathableContract;
use Helldar\LaravelLangPublisher\Support\Path\Json as JsonPath;
use Helldar\LaravelLangPublisher\Support\Path\Php as PhpPath;

trait Pathable
{
    protected function getPath(): PathableContract
    {
        return $this->wantsJson()
            ? $this->container(JsonPath::class)
            : $this->container(PhpPath::class);
    }
}
