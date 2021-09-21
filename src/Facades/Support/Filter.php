<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Facades\Support;

use Helldar\LaravelLangPublisher\Support\Filter as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Support keys(array $source)
 * @method static Support translated(array $array)
 */
class Filter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
