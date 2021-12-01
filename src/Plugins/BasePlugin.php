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

namespace LaravelLang\Publisher\Plugins;

use DragonCode\Contracts\LangPublisher\Plugin;
use DragonCode\Support\Facades\Helpers\Filesystem\Directory;
use LaravelLang\Publisher\Concerns\Paths;

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
