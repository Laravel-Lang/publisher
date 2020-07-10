<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Closure;
use Helldar\LaravelLangPublisher\Support\Arr as ArrSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array unique(array $array)
 * @method static array first(array $array)
 * @method static array keys(array $array)
 * @method static array transform(array $array, Closure $callback)
 */
final class Arr extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ArrSupport::class;
    }
}
