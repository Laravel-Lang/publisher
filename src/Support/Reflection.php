<?php

namespace Helldar\LaravelLangPublisher\Support;

use ReflectionClass;

final class Reflection
{
    /**
     * @throws \ReflectionException
     */
    public function getConstants(string $class): array
    {
        return $this->make($class)->getConstants();
    }

    /**
     * @throws \ReflectionException
     */
    protected function make(string $class)
    {
        return new ReflectionClass($class);
    }
}
