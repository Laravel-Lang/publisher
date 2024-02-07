<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Processors;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\LocaleList\Locale;

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
        Directory::ensureDelete($this->findDirectories($locale));
    }

    protected function files(Locale|string $locale): void
    {
        File::ensureDelete($this->findFiles($locale));
    }

    protected function findDirectories(Locale|string $locale): array
    {
        return $this->finder(Directory::class, $locale);
    }

    protected function findFiles(Locale|string $locale): array
    {
        return $this->finder(File::class, $locale);
    }

    protected function finder(Directory|File|string $filesystem, Locale|string $locale): array
    {
        $callback = $this->findCallback($locale);

        $names = [];

        foreach ($this->paths() as $path) {
            $items = $filesystem::names($path, $callback, true);

            $names[] = Arr::map($items, static fn (string $name) => Str::prepend($name, $path . '/'));
        }

        return Arr::of($names)->flatten()->unique()->toArray();
    }

    protected function findCallback(Locale|string $locale): callable
    {
        $locale = $locale->value ?? $locale;

        return static fn (string $path) => $locale === Path::filename($path);
    }

    protected function paths(): array
    {
        return Arr::of([
            $this->config->langPath(),
            base_path('vendor/laravel/framework/src/Illuminate/Translation/lang'),
            base_path('vendor/illuminate/translation/src/Illuminate/Translation/lang'),
            __DIR__ . '/../../vendor/laravel/framework/src/Illuminate/Translation/lang',
            __DIR__ . '/../../vendor/illuminate/translation/src/Illuminate/Translation/lang',
        ])
            ->flatten()
            ->filter(static fn (string $path) => is_dir($path) && file_exists($path))
            ->unique()
            ->toArray();
    }
}
