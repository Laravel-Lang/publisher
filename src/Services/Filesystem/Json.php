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

use LaravelLang\Publisher\Helpers\Filesystem;

class Json extends Base
{
    public function store(string $path, $content): string
    {
        $items = $this->sort($content);

        return Filesystem::store($path, $this->encode($items));
    }

    protected function encode(array $values): string
    {
        return json_encode($values, JSON_UNESCAPED_UNICODE ^ JSON_UNESCAPED_SLASHES ^ JSON_PRETTY_PRINT);
    }
}
