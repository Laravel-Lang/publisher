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

namespace LaravelLang\Publisher\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\Publisher\Facades\Helpers\Config;

trait Paths
{
    protected $trim_chars = '/\\';

    protected $directory_separator = DIRECTORY_SEPARATOR;

    protected function directory(string $path): string
    {
        return pathinfo($path, PATHINFO_DIRNAME);
    }

    protected function filename(string $filename): string
    {
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    protected function extension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    protected function path(string $base_path, ...$parameters): string
    {
        return Arr::of($parameters)
            ->map(fn (string $parameter) => trim($parameter, $this->trim_chars))
            ->implode($this->directory_separator)
            ->prepend($this->directory_separator)
            ->prepend(rtrim($base_path, $this->trim_chars))
            ->toString();
    }

    protected function vendorPath(string ...$parameters): string
    {
        return $this->path(Config::vendor(), ...$parameters);
    }

    protected function resourcesPath(string ...$parameters): string
    {
        return $this->path(Config::resources(), ...$parameters);
    }

    protected function resolvePath(string $path, string $locale): string
    {
        return Str::replaceFormat($path, compact('locale'), '{%s}');
    }
}
