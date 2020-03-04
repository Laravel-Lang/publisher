<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Contracts\Arr as ArrContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array unique(array $array)
 */
class Arr extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ArrContract::class;
    }
}
