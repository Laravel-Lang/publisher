<?php

namespace Helldar\LaravelLangPublisher\Support;

use ReflectionClass;

final class Reflection
{
    public function getConstants(string $class): array
    {
        return $this->make($class)->getConstants();
    }

    protected function make(string $class)
    {
        return new ReflectionClass($class);
    }
}
