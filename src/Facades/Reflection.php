<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Reflection as ReflectionSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getConstants(string $class)
 */
final class Reflection extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ReflectionSupport::class;
    }
}
