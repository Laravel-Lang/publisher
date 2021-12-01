<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
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
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Facades\Support;

use Illuminate\Support\Facades\Facade;
use LaravelLang\Publisher\Support\Filesystem\Manager;

/**
 * @method static array load(string $path)
 * @method static void delete(array|string $path)
 * @method static void store(string $path, array $content)
 */
class Filesystem extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Manager::class;
    }
}
