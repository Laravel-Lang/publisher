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

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Helpers\Config;
use LaravelLang\Publisher\Processors\Processor;
use LaravelLang\Publisher\Services\Converters\Text\CommonDecorator;
use LaravelLang\Publisher\Services\Converters\Text\SmartPunctuationDecorator;
use LaravelLang\Publisher\TextDecorator;

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
        $config = $this->config();

        return new $this->processor($this->output, $this->locales(), $this->decorator($config), $config);
    }

    protected function locales(): array
    {
        return Locales::installed();
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

    protected function getLocalesArgument(): array
    {
        $locales = $this->argument('locales');

        return is_array($locales) ? $locales : [$locales];
    }
}
