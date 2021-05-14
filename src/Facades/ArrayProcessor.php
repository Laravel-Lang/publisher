<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\ArrayProcessor as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Support keysAsString()
 * @method static Support of(array $items)
 */
final class ArrayProcessor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
