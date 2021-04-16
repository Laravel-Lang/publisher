<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Packages as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array get()
 * @method static int count()
 */
final class Packages extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
