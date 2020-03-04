<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Contracts\Locale as LocaleContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array available()
 * @method static array installed()
 * @method static string getDefault()
 * @method static string getFallback()
 */
final class Locale extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LocaleContract::class;
    }
}
