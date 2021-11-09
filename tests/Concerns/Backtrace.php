<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
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
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Tests\Concerns;

use Helldar\Support\Facades\Helpers\Arr;

trait Backtrace
{
    protected $backtrace_level = 5;

    protected function getCalledMethod(): string
    {
        return Arr::get($this->backtrace(), 'function');
    }

    protected function backtrace(): array
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, $this->backtrace_level);

        return array_pop($trace);
    }
}
