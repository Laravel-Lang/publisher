<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
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
