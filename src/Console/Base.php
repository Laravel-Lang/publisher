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

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use LaravelLang\Config\Services\PunctuationConfig;
use LaravelLang\Locales\Facades\Locales;
use LaravelLang\Publisher\Contracts\TextDecorator;
use LaravelLang\Publisher\Processors\Processor;
use LaravelLang\Publisher\Services\Converters\Text\CommonDecorator;
use LaravelLang\Publisher\Services\Converters\Text\SmartPunctuationDecorator;

abstract class Base extends Command
{
    protected ?string $question;

    protected Processor|string $processor;

    public function __construct(
        protected PunctuationConfig $punctuation,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->resolveProcessor()->prepare()->collect()->store();

        $this->output->newLine();
    }

    protected function resolveProcessor(): Processor
    {
        return app($this->processor, [
            'output'    => $this->output,
            'locales'   => $this->locales(),
            'decorator' => $this->decorator(),
        ]);
    }

    protected function locales(): array
    {
        return Locales::raw()->installed();
    }

    protected function decorator(): TextDecorator
    {
        return $this->punctuation->enabled
            ? new SmartPunctuationDecorator()
            : new CommonDecorator();
    }

    protected function confirmAll(): bool
    {
        if ($this->question && empty($this->argument('locales'))) {
            return $this->confirm($this->question);
        }

        return false;
    }

    protected function getLocalesArgument(): Collection
    {
        return collect($this->argument('locales'));
    }
}
