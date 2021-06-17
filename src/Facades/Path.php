<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Path as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string basename(string $filename)
 * @method static string extension(string $filename)
 * @method static string filename(string $filename)
 */
final class Path extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
