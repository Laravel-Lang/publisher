<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Contracts\Actionable;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\LaravelLangPublisher\Services\Command\Locales as LocalesSupport;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Str;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    use Containable;
    use Logger;

    protected $action;

    protected $pad = 0;

    protected $locales;

    abstract protected function processor(): Processor;

    public function handle()
    {
        $this->start();
        $this->ran();
        $this->end();
    }

    protected function ran(): void
    {
        foreach ($this->locales() as $locale) {
            foreach ($this->files() as $filename) {
                $status = $this->process($locale, $filename);

                $this->processed($locale, $status);
            }
        }
    }

    protected function process(string $locale, string $filename): string
    {
        return $this->processor()
            ->locale($locale)
            ->filename($filename, $this->hasInline())
            ->run();
    }

    protected function locales(): array
    {
        if (! empty($this->locales)) {
            return $this->locales;
        }

        return $this->locales = LocalesSupport::make($this, $this->action(), $this->targetLocales())->get();
    }

    protected function targetLocales(): array
    {
        return Locales::available();
    }

    protected function files(): array
    {
        return File::names(Path::source(LocalesList::ENGLISH), static function ($filename) {
            return ! Str::contains($filename, 'inline');
        });
    }

    protected function start(): void
    {
        $action = $this->action()->present(true);

        $this->info($action . ' localizations...');
    }

    protected function end(): void
    {
        $action = $this->action()->past();

        $this->info('Localizations have ben successfully ' . $action . '.');
    }

    protected function processed(string $locale, string $status): void
    {
        $locale = str_pad($locale . '...', $this->length() + 3);

        $this->info($locale . ' ' . $status);
    }

    protected function length(): int
    {
        if ($this->pad > 0) {
            return $this->pad;
        }

        return $this->pad = Arr::longestStringLength($this->locales());
    }

    protected function hasInline(): bool
    {
        return Config::hasInline();
    }

    protected function action(): Actionable
    {
        return $this->container($this->action);
    }

    protected function hasForce(): bool
    {
        return $this->boolOption('force');
    }

    protected function hasFull(): bool
    {
        return $this->boolOption('full');
    }

    protected function boolOption(string $key): bool
    {
        return $this->hasOption($key) && $this->option($key);
    }
}
