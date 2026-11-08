<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Services\Filesystem;

use LaravelLang\Publisher\Concerns\Has;
use LaravelLang\Publisher\Contracts\Filesystem;

class Manager implements Filesystem
{
    use Has;

    /** @var array<class-string<Filesystem>, Filesystem> */
    protected array $resolved = [];

    public function load(string $path): array
    {
        return $this->filesystem($path)->load($path);
    }

    public function store(string $path, $content): string
    {
        return $this->filesystem($path)->store($path, $content);
    }

    protected function filesystem(string $path): Filesystem
    {
        $class = $this->hasJson($path) ? Json::class : Php::class;

        return $this->resolved[$class] ??= new $class;
    }
}
