<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Contracts\Path as PathContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string source(string $locale = null, string $filename = null)
 * @method static string target(string $locale = null, string $filename = null)
 */
class Path extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PathContract::class;
    }
}
