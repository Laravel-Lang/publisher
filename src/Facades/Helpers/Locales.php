<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Facades\Helpers;

use Helldar\LaravelLangPublisher\Helpers\Locales as Helper;
use Illuminate\Support\Facades\Facade;

class Locales extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
