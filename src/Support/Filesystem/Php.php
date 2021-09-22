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

class Php extends Base
{
    public function load(string $path)
    {
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

    protected function hasAlignment(): bool
    {
        return Config::hasAlignment();
    }
}
