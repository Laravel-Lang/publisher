<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Illuminate\Container\Container;

/** @mixin \Helldar\LaravelLangPublisher\Concerns\Logger */
trait Containable
{
    protected static $containers = [];

    protected function container(string $class, array $parameters = [])
    {
        if (! isset(static::$containers[$class])) {
            $this->log('Creating container: ' . $class);

            static::$containers[$class] = Container::getInstance()->make($class, $parameters);
        }

        $this->log('Getting the container: ' . $class);

        return static::$containers[$class];
    }
}
