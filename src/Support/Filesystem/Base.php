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

namespace Helldar\LaravelLangPublisher\Support\Filesystem;

use Helldar\Contracts\Support\Filesystem;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Filesystem\File;

abstract class Base implements Filesystem
{
    protected function doesntExists(string $path): bool
    {
        return ! File::exists($path);
    }

    protected function correct(array $items): array
    {
        $callback = static function ($value) {
            return stripslashes($value);
        };

        return Arrayable::of($items)
            ->map($callback, true)
            ->renameKeys($callback)
            ->get();
    }
}
