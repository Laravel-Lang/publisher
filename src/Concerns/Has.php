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

use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\Support\Facades\Helpers\Str;

/**
 * @mixin \Helldar\LaravelLangPublisher\Concerns\Paths
 */
trait Has
{
    protected function hasJson(string $filename): bool
    {
        $extension = $this->extension($filename);

        return Str::lower($extension) === 'json';
    }

    protected function hasValidation(string $filename): bool
    {
        $name = $this->filename($filename);

        return Str::startsWith(Str::lower($name), 'validation');
    }

    protected function hasAlignment(): bool
    {
        return Config::hasAlignment();
    }

    protected function hasInline(): bool
    {
        return Config::hasInline();
    }
}
