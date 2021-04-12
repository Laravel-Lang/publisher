<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Path as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string directory(string $path)
 * @method static string extension(string $path)
 * @method static string filename(string $path)
 * @method static string locales(string $locale = null)
 * @method static string source(string $locale)
 * @method static string target(string $locale)
 */
final class Path extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
