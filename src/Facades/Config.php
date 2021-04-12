<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Config as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array excludes()
 * @method static array ignores()
 * @method static bool isAlignment()
 * @method static bool isInline()
 * @method static int getCase()
 * @method static string basePath()
 * @method static string localesPath()
 * @method static string resourcesPath()
 */
final class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
