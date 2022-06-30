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

namespace LaravelLang\Publisher\Processors;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;

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

    protected function directories(LocaleCode|string $locale): void
    {
        Directory::ensureDelete($this->findDirectories($locale));
    }

    protected function files(LocaleCode|string $locale): void
    {
        File::ensureDelete($this->findFiles($locale));
    }

    protected function findDirectories(LocaleCode|string $locale): array
    {
        $names = Directory::names($this->config->langPath(), $this->find($locale), true);

        return Arr::of($names)
            ->map(fn (string $name) => Str::prepend($name, $this->config->langPath() . '/'))
            ->toArray();
    }

    protected function findFiles(LocaleCode|string $locale): array
    {
        $names = File::names($this->config->langPath(), $this->find($locale), true);

        return Arr::of($names)
            ->map(fn (string $name) => Str::prepend($name, $this->config->langPath() . '/'))
            ->toArray();
    }

    protected function find(LocaleCode|string $locale): callable
    {
        $locale = $locale?->value ?? $locale;

        return static fn (string $path) => $locale === Path::filename($path);
    }
}
