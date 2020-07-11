<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Locale as LocaleSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array available(bool $is_json = false)
 * @method static array installed(bool $is_json = false)
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
