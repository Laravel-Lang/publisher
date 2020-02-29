<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Contracts\Config as ConfigContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getVendor()
 * @method static bool isAlignment()
 * @method static array getExclude(string $key, array $default = [])
 * @method static int getCase()
 */
class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ConfigContract::class;
    }
}
