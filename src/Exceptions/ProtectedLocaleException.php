<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Exceptions;

use RuntimeException;

class ProtectedLocaleException extends RuntimeException
{
    public function __construct(array|string $locales)
    {
        $locales = is_string($locales) ? $locales : implode(', ', $locales);

        parent::__construct("Can't delete protected locales: $locales.");
    }
}

