<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Contracts\Locale as LocaleContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array available()
 * @method static array installed()
 */
class Locale extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LocaleContract::class;
    }
}
