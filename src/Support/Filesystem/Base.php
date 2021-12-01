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

namespace LaravelLang\Publisher\Support\Filesystem;

use DragonCode\Contracts\Support\Filesystem;
use DragonCode\Support\Facades\Helpers\Ables\Arrayable;
use DragonCode\Support\Facades\Helpers\Filesystem\File;
use LaravelLang\Publisher\Concerns\Has;
use LaravelLang\Publisher\Concerns\Paths;

abstract class Base implements Filesystem
{
    use Has;
    use Paths;

    protected function doesntExists(string $path): bool
    {
        return ! File::exists($path);
    }

    protected function correct(array $items): array
    {
        $callback = static function ($value) {
            return is_string($value) ? stripslashes($value) : $value;
        };

        return Arrayable::of($items)
            ->map($callback, true)
            ->renameKeys($callback)
            ->get();
    }
}
