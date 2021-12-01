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

namespace LaravelLang\Publisher\Support\Filesystem;

use DragonCode\PrettyArray\Services\File as Pretty;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Filesystem\File;

class Json extends Base
{
    public function load(string $path): array
    {
        if ($this->doesntExists($path)) {
            return [];
        }

        $content = Pretty::make()->loadRaw($path);

        $items = json_decode($content, true);

        return $this->correct($items);
    }

    public function store(string $path, $content): string
    {
        Arr::storeAsJson($path, $content, false, JSON_UNESCAPED_UNICODE ^ JSON_PRETTY_PRINT);

        return $path;
    }

    public function delete(string $path): void
    {
        File::ensureDelete($path);
    }
}
