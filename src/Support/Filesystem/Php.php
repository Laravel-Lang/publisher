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

use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\PrettyArray\Services\File as Pretty;
use Helldar\PrettyArray\Services\Formatter;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Filesystem\File;

class Php extends Base
{
    public function load(string $path): array
    {
        $path = $this->resolveAlignedPath($path);

        if ($this->doesntExists($path)) {
            return [];
        }

        $items = Pretty::make()->load($path);

        return $this->correct($items);
    }

    public function store(string $path, $content): string
    {
        $service = $this->formatter();

        Pretty::make($service->raw($content))->store($path);

        return $path;
    }

    public function delete(string $path): void
    {
        Directory::ensureDelete($path);
    }

    protected function resolveAlignedPath(string $path): string
    {
        if (! $this->hasInline()) {
            return $path;
        }

        $directory = $this->directory($path);
        $filename  = $this->filename($path);
        $extension = $this->extension($path);

        $inline_path = $this->path($directory, $filename . '-inline.' . $extension);

        return File::exists($inline_path) ? $inline_path : $path;
    }

    protected function formatter(): Formatter
    {
        $formatter = Formatter::make();

        $this->setCase($formatter);
        $this->setAlignment($formatter);
        $this->setKeyToString($formatter);

        return $formatter;
    }

    protected function setCase(Formatter $formatter): void
    {
        $formatter->setCase(
            $this->getCase()
        );
    }

    protected function setAlignment(Formatter $formatter): void
    {
        if ($this->hasAlignment()) {
            $formatter->setEqualsAlign();
        }
    }

    protected function setKeyToString(Formatter $formatter): void
    {
        $formatter->setKeyAsString();
    }

    protected function getCase(): int
    {
        return Config::case();
    }
}
