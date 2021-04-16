<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use ReflectionClass;

final class Reflection
{
    use Logger;

    /**
     * @throws \ReflectionException
     */
    public function getConstants(string $class): array
    {
        $this->log('Getting a list of object constants:', $class);

        return $this->make($class)->getConstants();
    }

    /**
     * @throws \ReflectionException
     */
    protected function make(string $class): ReflectionClass
    {
        $this->log('Creating a reflection object class:', $class);

        return new ReflectionClass($class);
    }
}
