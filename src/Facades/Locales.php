<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Locales as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array available()
 */
final class Locales extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
