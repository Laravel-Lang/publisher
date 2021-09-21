<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Facades\Support;

use Illuminate\Support\Facades\Facade;

/**
 * @method static only keys(array $source)
 * @method static only translated(array $array)
 */
class Filter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return only::class;
    }
}
