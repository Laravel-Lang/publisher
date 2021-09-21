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

use Helldar\Contracts\LangPublisher\Processor;
use Helldar\LaravelLangPublisher\Concerns\Optionable;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Helldar\LaravelLangPublisher\Facades\Support\Filesystem;
use Helldar\LaravelLangPublisher\Facades\Support\Filter;
use Illuminate\Console\Command;

abstract class Base extends Command
{
    use Optionable;
    use Paths;

    protected $processor;

    public function handle()
    {
        $this->collecting();

        $this->store($this->filter());
    }

    protected function collecting(): void
    {
        foreach ($this->plugins() as $provider) {
            $this->info('Collecting ' . get_class($provider) . '...');

            $this->getProcessor()->provider($provider);
        }
    }

    protected function filter(): array
    {
        $this->info('Filtering...');

        $source     = $this->getProcessor()->source();
        $translated = $this->getProcessor()->translated();

        return Filter::keys($source)
            ->translated($translated)
            ->get();
    }

    protected function store(array $items): void
    {
        $this->info('Storing...');

        foreach ($items as $filename => $values) {
            $path = $this->resourcesPath($filename);

            Filesystem::store($path, $values);
        }
    }

    /**
     * @return \Helldar\Contracts\LangPublisher\Provider[]
     */
    protected function plugins(): array
    {
        return Config::plugins();
    }

    protected function getProcessor(): Processor
    {
        if (! is_string($this->processor)) {
            return $this->processor;
        }

        $locales = $this->targetLocales();
        $force   = $this->hasForce();

        return $this->processor = new $this->processor($locales, $force);
    }

    protected function targetLocales(): array
    {
        return Locales::installed();
    }
}
