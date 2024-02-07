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

namespace LaravelLang\Publisher\Exceptions;

use LaravelLang\LocaleList\Locale;

class ProtectedLocaleException extends BaseException
{
    public function __construct(array|Locale|string $locales)
    {
        $locales = $this->stringify($locales);

        parent::__construct("Can't delete protected locales: $locales.");
    }
}
