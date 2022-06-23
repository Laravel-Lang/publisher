<?php

namespace LaravelLang\Publisher\Facades\Helpers;

use DragonCode\Support\Facades\Facade;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Helpers\Locales as Helper;

/**
 * @method static array available()
 * @method static array installed()
 * @method static array protects()
 * @method static bool isAvailable(string|LocaleCode|null $locale)
 * @method static bool isInstalled(string|LocaleCode|null $locale)
 * @method static bool isProtected(string|LocaleCode|null $locale)
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
