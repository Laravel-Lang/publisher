<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
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
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use LaravelLang\Publisher\Concerns\Ask;
use LaravelLang\Publisher\Concerns\Paths;
use LaravelLang\Publisher\Facades\Helpers\Config;
use LaravelLang\Publisher\Facades\Helpers\Locales;

abstract class Base extends Command
{
    use Ask;
    use Paths;

    /** @var \DragonCode\Contracts\LangPublisher\Processor */
    protected $processor;

    public function handle()
    {
        $this->resolveProcessor();

        $this->hasPlugins()
            ? $this->collecting()
            : $this->pluginsNotFound();

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

    protected function pluginsNotFound(): void
    {
        $this->warn('Could not find plugins available for processing.');
    }

    /**
     * @return \DragonCode\Contracts\LangPublisher\Provider[]
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

    protected function hasPlugins(): bool
    {
        return ! empty($this->plugins());
    }

    protected function hasFull(): bool
    {
        return $this->hasOption('full')
            && $this->option('full');
    }
}
