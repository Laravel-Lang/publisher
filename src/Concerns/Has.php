<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Concerns;

use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Str;

trait Has
{
    protected function hasJson(string $path, bool $extension = true): bool
    {
        $name = $extension ? Path::extension($path) : Path::filename($path);

        return Str::of($name)->lower()->contains('json');
    }

    protected function hasValidation(string $path): bool
    {
        $name = Path::filename($path);

        return Str::of($name)->lower()->contains('validation');
    }
}
