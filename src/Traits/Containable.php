<?php

namespace Helldar\LaravelLangPublisher\Traits;

use Illuminate\Container\Container;

trait Containable
{
    protected function container(string $class, array $parameters = [])
    {
        return Container::getInstance()->make($class, $parameters);
    }
}
