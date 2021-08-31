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

/** @mixin \Illuminate\Console\Command */
trait Optionable
{
    protected function hasForce(): bool
    {
        return $this->boolOption('force');
    }

    protected function hasFull(): bool
    {
        return $this->boolOption('full');
    }

    protected function hasInline(): bool
    {
        return Config::hasInline();
    }

    protected function boolOption(string $key): bool
    {
        return $this->hasOption($key) && $this->option($key);
    }
}
