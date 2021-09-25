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

namespace Helldar\LaravelLangPublisher\Plugins;

use Helldar\Contracts\LangPublisher\Plugin;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

abstract class BasePlugin implements Plugin
{
    use Paths;

    public function vendor(): ?string
    {
        return null;
    }

    public function has(): bool
    {
        if ($vendor = $this->vendor()) {
            $path = $this->vendorPath($vendor);

            return Directory::exists($path);
        }

        return true;
    }
}
