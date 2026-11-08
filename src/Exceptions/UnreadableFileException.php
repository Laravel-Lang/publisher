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

namespace LaravelLang\Publisher\Exceptions;

class UnreadableFileException extends BaseException
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('The "%s" file has an unsupported extension or contains invalid data.', $path));
    }
}
