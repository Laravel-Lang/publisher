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
use Helldar\LaravelLangPublisher\Concerns\Has;
use Helldar\Support\Concerns\Resolvable;

class Manager
{
    use Resolvable;
    use Has;

    public function load(string $path): array
    {
        return $this->filesystem($path)->load($path);
    }

    public function store(string $path, array $content): void
    {
        $this->filesystem($path)->store($path, $content);
    }

    protected function filesystem(string $path): Filesystem
    {
        return $this->hasJson($path)
            ? static::resolveInstance(Json::class)
            : static::resolveInstance(Php::class);
    }
}