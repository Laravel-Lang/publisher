<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Config\Config as Instance;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array excludes()
 * @method static array plugins()
 * @method static bool hasAlignment()
 * @method static bool hasInline()
 * @method static int case()
 * @method static string resources()
 * @method static string vendor()
 */
class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Instance::class;
    }
}
