<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Concerns\Files;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Concerns\Pathable;
use Helldar\LaravelLangPublisher\Concerns\Plugins;
use Helldar\LaravelLangPublisher\Contracts\Actionable;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\Info;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Facades\Packages;
use Helldar\LaravelLangPublisher\Facades\Validator;
use Helldar\LaravelLangPublisher\Services\Command\Locales as LocalesSupport;
use Helldar\LaravelLangPublisher\Support\Info as InfoSupport;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    use Containable;
    use Contains;
    use Files;
    use Logger;
    use Pathable;
    use Plugins;

    protected $action;

    protected $locales_length = 0;

    protected $locales;

    protected $processed = [];

    abstract protected function processor(?string $filename): Processor;

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
        $this->log('Starting processing of the package list...');

        foreach ($this->packages() as $package) {
            $this->log('Plugins handling:', $package);

            $this->validatePackage($package);

            $this->ranLocales($package);
        }
    }

    protected function ranLocales(string $package): void
    {
        $this->log('Starting processing of the locales list for the', $package, 'package...');

        foreach ($this->locales() as $locale) {
            $this->log('Localization handling:', $locale);

            $this->validateLocale($locale);

            $this->ranFiles($package, $locale);
            $this->ranPlugins($package, $locale);
        }
    }

    protected function ranFiles(string $package, string $locale): void
    {
        $this->log('Starting processing of the files for the', $package, 'package and', $locale, 'localization...');

        foreach ($this->files($package, $locale) as $filename) {
            $this->log('Processing the localization file:', $filename);

            $filename = $this->pathResolveLocaleFilename($locale, $filename);

            $this->processing($locale, $filename, $package);

            $status = $this->process($package, $locale, $filename);

            $this->pushProcessed($filename);

            $this->processed($locale, $filename, $status, $package);
        }
    }

    protected function ranPlugins(string $package, string $locale): void
    {
        $this->log('Starting processing of plugin files for the', $package, 'package and', $locale, 'localization...');

        foreach ($this->plugins() as $plugin) {
            foreach ($plugin->source() as $source) {
                $target = $plugin->targetPath($locale, $source);

                $this->processing($locale, $source, $package);

                $status = $this->process($package, $locale, $source, $target);

                $this->pushProcessed($target);

                $this->processed($locale, $source, $status, $package);
            }
        }
    }

    protected function process(?string $package, ?string $locale, ?string $source, string $target = null): string
    {
        $this->log('Launching the processor for localization:', $locale, ',', $source);

        return $this->processor($source)
            ->force($this->hasForce() || $this->hasProcessed($target))
            ->whenPackage($package)
            ->whenLocale($locale)
            ->whenSourceFilename($source, $this->hasInline())
            ->whenTargetFilename($target ?: $source)
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
        $this->log('Getting a list of packages available for processing...');

        return Packages::get();
    }

    protected function start(): void
    {
        $this->log('Running the console command:', parent::class);

        $action = $this->action()->present(true);

        $this->info($action . ' localizations...');
    }

    protected function end(): void
    {
        $this->log('Completing the execution of the console command...');

        $action = $this->action()->past();

        $this->info('Localizations have ben successfully ' . $action . '.');
    }

    protected function processing(string $locale, string $filename, string $package = null): void
    {
        $this->log('Displaying a message about the start of file processing: locale is', $locale, ', filename is', $filename, ', package is', $package . '...');

        $message = $this->message($locale, $filename, $package)->start();

        $this->output->write($message);
    }

    protected function processed(string $locale, string $filename, string $status, string $package = null): void
    {
        $this->log('Displaying a message about the finish of file processing: locale is', $locale, ', filename is', $filename, ', package is', $package . '...');

        $message = $this->message($locale, $filename, $package)->finish($status);

        $this->output->writeln($message);
    }

    protected function message(string $locale, string $filename, string $package = null): InfoSupport
    {
        $this->log('Preparing an object for displaying a message: locale is', $locale, ', filename is', $filename, ', package is', $package . '...');

        return Info::same()
            ->package($package)
            ->locale($locale, $this->localesLength())
            ->filename($filename, $this->filesLength());
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

    protected function pushProcessed(?string $filename): void
    {
        $this->log('Add a link to the processed file to the cache:', $filename);

        if ($filename && ! $this->hasProcessed($filename)) {
            $this->processed[] = $filename;
        }
    }

    protected function hasProcessed(?string $filename): bool
    {
        $this->log('Check if the file was processed earlier:', $filename);

        return $filename && in_array($filename, $this->processed, true);
    }

    protected function hasForce(): bool
    {
        $this->log('Getting the value of the "force" option...');

        return $this->boolOption('force');
    }

    protected function hasFull(): bool
    {
        $this->log('Getting the value of the "full" option...');

        return $this->boolOption('full');
    }

    protected function boolOption(string $key): bool
    {
        $this->log('Getting the value of the "', $key, '" option...');

        return $this->hasOption($key) && $this->option($key);
    }

    protected function validateLocale(string $locale): void
    {
        $this->log('Calling the localization validation method: ', $locale, '...');

        Validator::locale($locale);
    }

    protected function validatePackage(string $package): void
    {
        $this->log('Calling the package validation method: ', $package, '...');

        Validator::package($package);
    }

    protected function clean(): void
    {
        $this->log('Clear the variable from the saved localizations...');

        $this->locales = null;
    }
}
