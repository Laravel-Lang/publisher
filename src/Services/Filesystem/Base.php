<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Services\Filesystem;

use LaravelLang\Publisher\Contracts\Filesystem;
use LaravelLang\Publisher\Concerns\Has;
use LaravelLang\Publisher\Helpers\Config;
use LaravelLang\Publisher\Helpers\Filesystem as Files;
use LaravelLang\Publisher\Helpers\KeySorter;

abstract class Base implements Filesystem
{
    use Has;

    protected PhpFormatter $formatter;

    public function __construct(
        protected Config $config = new Config
    ) {
        $this->formatter = new PhpFormatter($this->config->hasAlign());
    }

    public function load(string $path): array
    {
        if (Files::exists($path)) {
            return Files::load($path);
        }

        return [];
    }

    protected function sort(array $items): array
    {
        return KeySorter::sort($items);
    }
}
