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
use DragonCode\Support\Concerns\Resolvable;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Concerns\Has;
use LaravelLang\Publisher\Concerns\Paths;

class Manager
{
    use Has;
    use Paths;
    use Resolvable;

    public function load(string $path): array
    {
        return $this->filesystem($path)->load($path);
    }

    public function store(string $path, array $content): void
    {
        $this->filesystem($path)->store($path, $content);
    }

    /**
     * @param array|string $path
     */
    public function delete($path): void
    {
        foreach (Arr::wrap($path) as $name) {
            $this->filesystem($name)->delete($name);
        }
    }

    protected function filesystem(string $path): Filesystem
    {
        return $this->hasJson($path)
            ? static::resolveInstance(Json::class)
            : static::resolveInstance(Php::class);
    }
}
