<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Contracts\Actionable;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Facades\Message;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\LaravelLangPublisher\Facades\Validator;
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

    protected $locales_length = 0;

    protected $files_length = 0;

    protected $files;

    protected $locales;

    abstract protected function processor(): Processor;

    public function handle()
    {
        $this->setLogger();
        $this->start();
        $this->clean();
        $this->ran();
        $this->end();
    }

    protected function ran(): void
    {
        foreach ($this->packages() as $package) {
            $this->log('Packages handling: ' . $package);

            $this->validatePackage($package);

            foreach ($this->locales() as $locale) {
                $this->log('Localization handling: ' . $locale);

                $this->validateLocale($locale);

                foreach ($this->files($package) as $filename) {
                    $this->log('Processing the localization file: ' . $filename);

                    $status = $this->process($package, $locale, $filename);

                    $this->processed($locale, $filename, $status, $package);
                }
            }
        }
    }

    protected function process(string $package, string $locale, string $filename): string
    {
        $this->log('Launching the processor for localization: ' . $locale . ', ' . $filename);

        return $this->processor()
            ->force($this->hasForce())
            ->package($package)
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

    protected function packages(): array
    {
        return Config::packages();
    }

    protected function files(string $package): array
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

    protected function processed(string $locale, string $filename, string $status, string $package = null): void
    {
        $message = Message::same()
            ->length($this->localesLength(), $this->filesLength())
            ->package($package)
            ->locale($locale)
            ->filename($filename)
            ->status($status)
            ->get();

        $this->line($message);
    }

    protected function localesLength(): int
    {
        $this->log('Getting the maximum length of a localization string...');

        if ($this->locales_length > 0) {
            return $this->locales_length;
        }

        $this->log('Calculating the maximum length of a localization string...');

        return $this->locales_length = Arr::longestStringLength($this->locales());
    }

    protected function filesLength(): int
    {
        $this->log('Getting the maximum length of a filenames...');

        if ($this->files_length > 0) {
            return $this->files_length;
        }

        $this->log('Calculating the maximum length of a filenames...');

        return $this->files_length = Arr::longestStringLength($this->files());
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
        Validator::locale($locale);
    }

    protected function validatePackage(string $package): void
    {
        Validator::package($package);
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
