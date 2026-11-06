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

namespace LaravelLang\Publisher\Processors;

use Illuminate\Support\Arr;
use LaravelLang\LocaleList\Locale;
use LaravelLang\Publisher\Helpers\Filesystem;

class Remove extends Processor
{
    public function collect(): Processor
    {
        return $this;
    }

    public function store(): void
    {
        foreach ($this->locales as $locale) {
            $this->directories($locale);
            $this->files($locale);
        }
    }

    protected function directories(Locale|string $locale): void
    {
        Filesystem::ensureDeleteDirectory($this->findDirectories($locale));
    }

    protected function files(Locale|string $locale): void
    {
        Filesystem::ensureDeleteFile($this->findFiles($locale));
    }

    protected function findDirectories(Locale|string $locale): array
    {
        return $this->finder(Filesystem::directories(...), $locale);
    }

    protected function findFiles(Locale|string $locale): array
    {
        return $this->finder(Filesystem::files(...), $locale);
    }

    protected function finder(callable $find, Locale|string $locale): array
    {
        $callback = $this->findCallback($locale);

        $names = [];

        foreach ($this->paths() as $path) {
            $items = $find($path, $callback, true);

            $names[] = array_map(static fn (string $name) => $path . '/' . $name, $items);
        }

        return array_values(array_unique(Arr::flatten($names)));
    }

    protected function findCallback(Locale|string $locale): callable
    {
        $locale = $locale->value ?? $locale;

        return static fn (string $path) => $locale === pathinfo($path, PATHINFO_FILENAME);
    }

    protected function paths(): array
    {
        $paths = [
            $this->config->langPath(),
            base_path('vendor/laravel/framework/src/Illuminate/Translation/lang'),
            base_path('vendor/illuminate/translation/src/Illuminate/Translation/lang'),
            __DIR__ . '/../../vendor/laravel/framework/src/Illuminate/Translation/lang',
            __DIR__ . '/../../vendor/illuminate/translation/src/Illuminate/Translation/lang',
        ];

        return array_unique(array_filter($paths, static fn (string $path) => is_dir($path)));
    }
}
