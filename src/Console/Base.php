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

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use LaravelLang\Locales\Facades\Locales;
use LaravelLang\Publisher\Contracts\TextDecorator;
use LaravelLang\Publisher\Helpers\Config;
use LaravelLang\Publisher\Processors\Processor;
use LaravelLang\Publisher\Services\Converters\Text\CommonDecorator;
use LaravelLang\Publisher\Services\Converters\Text\SmartPunctuationDecorator;

abstract class Base extends Command
{
    protected ?string $question;

    protected Processor|string $processor;

    public function handle(): void
    {
        $this->resolveProcessor()->prepare()->collect()->store();

        $this->output->newLine();
    }

    protected function resolveProcessor(): Processor
    {
        $config = $this->config();

        return new $this->processor($this->output, $this->locales(), $this->decorator($config), $config);
    }

    protected function locales(): array
    {
        return Locales::raw()->installed();
    }

    protected function decorator(Config $config): TextDecorator
    {
        return $config->hasSmartPunctuation() ? new SmartPunctuationDecorator($config) : new CommonDecorator($config);
    }

    protected function config(): Config
    {
        return new Config();
    }

    protected function confirmAll(): bool
    {
        if (empty($this->argument('locales')) && $question = $this->question) {
            return $this->confirm($question);
        }

        return false;
    }

    protected function getLocalesArgument(): Collection
    {
        return collect($this->argument('locales'));
    }
}
