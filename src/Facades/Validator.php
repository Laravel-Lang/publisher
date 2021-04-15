<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Validator as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void locale(string $locale)
 * @method static void package(string $locale)
 */
class Validator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
