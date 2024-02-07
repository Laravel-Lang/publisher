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

use DragonCode\Support\Facades\Filesystem\Path;
use Illuminate\Support\Str;

trait Has
{
    protected function hasJson(string $path, bool $extension = true): bool
    {
        $name = $extension ? Path::extension($path) : Path::filename($path);

        return Str::contains($name, 'json', true);
    }

    protected function hasValidation(string $path): bool
    {
        $name = Path::filename($path);

        return Str::contains($name, 'validation', true);
    }
}
