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

    protected $files;

    protected $locales;

    public function handle()
    {
        $this->start();
        $this->clean();
        $this->ran();
        $this->end();
    }

    abstract protected function processor(): Processor;

    protected function ran(): void
    {
        foreach ($this->locales() as $locale) {
            $this->log('Localization handling: ' . $locale);

            $this->validateLocale($locale);

            foreach ($this->files() as $filename) {
                $this->log('Processing the localization file: ' . $filename);

                $status = $this->process($locale, $filename);

                $this->processed($locale, $status);
            }
        }
    }

    protected function process(string $locale, string $filename): string
    {
        $this->log('Launching the processor for localization: ' . $locale . ', ' . $filename);

        return $this->processor()
            ->force($this->hasForce())
            ->locale($locale)
            ->filename($filename, $this->hasInline())
            ->run();
    }

    protected function locales(): array
    {
        $this->log('Getting a list of localizations...');

        if (! empty($this->locales)) {
            return $this->locales;
        }

        return $this->locales = LocalesSupport::make($this->input, $this->output, $this->action(), $this->targetLocales())->get();
    }

    protected function targetLocales(): array
    {
        $this->log('Getting a list of installed localizations...');

        return Locales::installed();
    }

    protected function files(): array
    {
        $this->log('Getting a list of files...');

        if (! empty($this->files)) {
            return $this->files;
        }

        return $this->files = File::names(Path::source(LocalesList::ENGLISH), static function ($filename) {
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
        $this->log('Getting the maximum length of a localization string...');

        if ($this->pad > 0) {
            return $this->pad;
        }

        $this->log('Calculating the maximum length of a localization string...');

        return $this->pad = Arr::longestStringLength($this->locales());
    }

    protected function hasInline(): bool
    {
        $this->log('Getting a use case for a validation file.');

        return Config::hasInline();
    }

    protected function action(): Actionable
    {
        $this->log('Getting the action...');

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

    protected function validateLocale(string $locale): void
    {
        Locales::validate($locale);
    }

    protected function doesntProtect(string $locale): bool
    {
        return ! Locales::isProtected($locale);
    }

    protected function clean(): void
    {
        $this->log('Clear the variable from the saved localizations...');

        $this->locales = null;
    }
}
