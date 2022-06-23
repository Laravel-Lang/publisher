<?php

namespace LaravelLang\Publisher\Facades\Helpers;

use DragonCode\Support\Facades\Facade;
use LaravelLang\Publisher\Helpers\Locales as Helper;

/**
 * @method static array available()
 * @method static array installed()
 * @method static array protects()
 * @method static bool isAvailable(?string $locale)
 * @method static bool isInstalled(?string $locale)
 * @method static bool isProtected(?string $locale)
 * @method static string getDefault()
 * @method static string getFallback()
 */
class Locales extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
