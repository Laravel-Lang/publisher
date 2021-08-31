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

namespace Helldar\LaravelLangPublisher\Facades\Support;

use Helldar\LaravelLangPublisher\Support\Filesystem\Manager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array load(string $path)
 * @method static void store(string $path, array $content)
 */
class Filesystem extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Manager::class;
    }
}
