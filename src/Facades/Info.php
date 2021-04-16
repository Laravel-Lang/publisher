<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Info as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Support same()
 */
final class Info extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
