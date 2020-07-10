<?php

namespace Helldar\LaravelLangPublisher\Traits;

use Illuminate\Container\Container;

trait Containable
{
    protected static $containers = [];

    protected function container(string $class)
    {
        if (! isset(static::$containers[$class])) {
            static::$containers[$class] = Container::getInstance()->make($class);
        }

        return static::$containers[$class];
    }
}
