<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Processors;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;

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

    protected function directories(string $locale): void
    {
        Directory::ensureDelete($this->findDirectories($locale));
    }

    protected function files(string $locale): void
    {
        File::ensureDelete($this->findFiles($locale));
    }

    protected function findDirectories(string $locale): array
    {
        return Directory::names($this->config->langPath(), $this->find($locale), true);
    }

    protected function findFiles(string $locale): array
    {
        return File::names($this->config->langPath(), $this->find($locale), true);
    }

    protected function find(string $locale): callable
    {
        return static fn (string $path) => $path === $locale;
    }
}
