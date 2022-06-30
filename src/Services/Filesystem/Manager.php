<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2022 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Services\Filesystem;

use DragonCode\Contracts\Support\Filesystem;
use DragonCode\Support\Concerns\Resolvable;
use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Concerns\Has;

class Manager implements Filesystem
{
    use Has;
    use Resolvable;

    public function load(string $path): array
    {
        return $this->filesystem($path)->load($path);
    }

    public function store(string $path, $content): string
    {
        return $this->filesystem($path)->store($path, $content);
    }

    public function delete(array|string $path): void
    {
        foreach (Arr::wrap($path) as $item) {
            is_dir($item) ? Directory::ensureDelete($item) : File::ensureDelete($item);
        }
    }

    protected function filesystem(string $path): Filesystem
    {
        return $this->hasJson($path)
            ? static::resolveInstance(Json::class)
            : static::resolveInstance(Php::class);
    }
}
