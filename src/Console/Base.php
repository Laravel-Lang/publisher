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

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Processors\Processor;

abstract class Base extends Command
{
    protected ?string $question;

    protected Processor|string $processor;

    public function handle()
    {
        $this->resolveProcessor()->prepare()->collect()->store();

        $this->output->newLine();
    }

    protected function resolveProcessor(): Processor
    {
        return new $this->processor($this->output, $this->locales());
    }

    protected function locales(): array
    {
        return Locales::installed();
    }

    protected function confirmAll(): bool
    {
        if (empty($this->argument('locales')) && $question = $this->question) {
            return $this->confirm($question);
        }

        return false;
    }

    protected function getLocalesArgument(): array
    {
        $locales = $this->argument('locales');

        return is_array($locales) ? $locales : [$locales];
    }
}
