<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Arr as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array unique(array $array)
 */
final class Arr extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
