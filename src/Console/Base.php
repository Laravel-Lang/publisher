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
use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Illuminate\Console\Command;

abstract class Base extends Command
{
    use Optionable;

    protected $processor;

    public function handle()
    {
        $this->collecting();
        $this->store();
    }

    protected function collecting(): void
    {
        foreach ($this->plugins() as $provider) {
            $this->info('Collecting ' . get_class($provider) . '...');

            $this->getProcessor()->provider($provider);
        }
    }

    protected function store(): void
    {
        $this->info('Storing...');

        $this->getProcessor()->store();
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
        if (! empty($this->processor)) {
            return $this->processor;
        }

        /** @var Processor $processor */
        $processor = new $this->processor();

        return $this->processor = $processor
            ->locales($this->targetLocales())
            ->hasForce($this->hasForce());
    }

    protected function targetLocales(): array
    {
        return Locales::installed();
    }
}
