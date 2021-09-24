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

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Concerns\Ask;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Illuminate\Console\Command;

abstract class Base extends Command
{
    use Ask;
    use Paths;

    /** @var \Helldar\Contracts\LangPublisher\Processor */
    protected $processor;

    public function handle()
    {
        $this->resolveProcessor();

        $this->collecting();

        $this->finish();
    }

    protected function finish(): void
    {
        $this->info('Saving changes...');

        $this->processor->finish();
    }

    protected function resolveProcessor(): void
    {
        $locales = $this->targetLocales();
        $full    = $this->hasFull();

        $this->processor = new $this->processor($locales, $full);
    }

    protected function collecting(): void
    {
        foreach ($this->plugins() as $provider) {
            $this->info('Processing ' . get_class($provider) . '...');

            $this->processor->handle($provider);
        }
    }

    /**
     * @return \Helldar\Contracts\LangPublisher\Provider[]
     */
    protected function plugins(): array
    {
        return Config::plugins();
    }

    protected function targetLocales(): array
    {
        return Locales::installed();
    }

    protected function getAllLocales(): array
    {
        return Locales::installed();
    }

    protected function hasFull(): bool
    {
        return $this->hasOption('full')
            && $this->option('full');
    }
}
