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

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use LaravelLang\Publisher\Processors\Processor;

abstract class Base extends Command
{
    protected Processor|string $processor;

    protected bool $reset = false;

    abstract protected function locales(): array;

    public function handle()
    {
        $this->resolveProcessor()->collect()->store();
    }

    protected function resolveProcessor(): Processor
    {
        return new $this->processor($this->output, $this->locales(), $this->reset);
    }
}
