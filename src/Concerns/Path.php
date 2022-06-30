<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2022 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Concerns;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path as PathHelper;
use DragonCode\Support\Facades\Helpers\Str;

trait Path
{
    protected function localeFilename(string $locale, string $path, bool $has_inline = false): string
    {
        $path = Str::replaceFormat($path, compact('locale'), '{%s}');

        $directory = PathHelper::dirname($path);
        $filename  = PathHelper::filename($path);
        $extension = PathHelper::extension($path);

        $main   = "$directory/$filename.$extension";
        $inline = "$directory/$filename-inline.$extension";

        return $has_inline && File::exists($inline) ? $inline : $main;
    }
}
