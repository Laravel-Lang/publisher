<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Path as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string basename(string $path)
 * @method static string clean(string $path = null, bool $both = false)
 * @method static string directory(string $path)
 * @method static string extension(string $path)
 * @method static string filename(string $path)
 * @method static string locales(string $package, string $locale = null)
 * @method static string source(string $package, string $locale)
 * @method static string target(string $locale, bool $is_json = false)
 * @method static string targetFull(string $locale, ?string $filename)
 */
final class Path extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
