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

namespace Helldar\LaravelLangPublisher\Concerns;

use Illuminate\Support\Collection;

trait Paths
{
    protected $trim_chars = '/\\';

    protected $directory_separator = DIRECTORY_SEPARATOR;

    protected function extension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    protected function filename(string $filename): string
    {
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    protected function path(string $base_path, ...$parameters): string
    {
        $base_path = rtrim($base_path, $this->trim_chars);

        $parameters = Collection::make($parameters)
            ->map(static function (string $parameter) {
                return trim($parameter, $this->trim_chars);
            })->implode($this->directory_separator);

        return $base_path . $this->directory_separator . $parameters;
    }
}
