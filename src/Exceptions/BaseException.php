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

namespace LaravelLang\Publisher\Exceptions;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales;
use RuntimeException;

class BaseException extends RuntimeException
{
    protected function stringify(array|string|Locales $locales): string
    {
        $locales = is_array($locales) ? $locales : [$locales];

        return Arr::of($locales)
            ->map(static fn (string|Locales $locale) => $locale?->value ?? $locale)
            ->implode(', ')
            ->toString();
    }
}
