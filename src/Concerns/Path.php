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

namespace LaravelLang\Publisher\Concerns;

trait Path
{
    protected function localeFilename(string $locale, string $path, bool $has_inline = false): string
    {
        $path = str_replace('{locale}', $locale, $path);

        $directory = pathinfo($path, PATHINFO_DIRNAME);
        $filename  = pathinfo($path, PATHINFO_FILENAME);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        $main   = "$directory/$filename.$extension";
        $inline = "$directory/$filename-inline.$extension";

        return $has_inline && is_file($inline) ? $inline : $main;
    }
}
