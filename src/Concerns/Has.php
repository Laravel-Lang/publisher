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

use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\Publisher\Facades\Helpers\Config;

/**
 * @mixin \LaravelLang\Publisher\Concerns\Paths
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
