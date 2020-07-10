<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Locale as LocaleSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array available()
 * @method static array installed()
 * @method static array protects()
 * @method static bool isProtected(string $locale)
 * @method static string getDefault()
 * @method static string getFallback()
 */
final class Locale extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LocaleSupport::class;
    }
}
