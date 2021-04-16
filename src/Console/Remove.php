<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Contracts\Processor;
use Helldar\LaravelLangPublisher\Support\Actions\Remove as Action;
use Illuminate\Support\Facades\File;

final class Remove extends BaseCommand
{
    protected $signature = 'lang:rm'
    . ' {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Remove localizations.';

    protected $action = Action::class;

    protected function ran(): void
    {
        $this->log('Starting processing of the locales list...');

        foreach ($this->locales() as $locale) {
            $this->log('Localization handling: ' . $locale);

            $this->validateLocale($locale);

            $this->processing($locale, $locale);

            $status = $this->doesntProtect($locale) ? $this->delete($locale) : Status::SKIPPED;

            $this->processed($locale, $locale, $status);
        }
    }

    protected function delete(string $locale): string
    {
        $this->log('Removing json and php localization files:', $locale);

        $status_dir  = $this->deleteDirectory($locale);
        $status_file = $this->deleteFile($locale);

        return $status_dir === $status_file ? $status_dir : Status::DELETED;
    }

    protected function deleteDirectory(string $locale): string
    {
        $this->log('Removing the localization directory for the locale:', $locale);

        $path = $this->pathTarget($locale);

        if (File::exists($path)) {
            File::deleteDirectory($path);

            return Status::DELETED;
        }

        return Status::SKIPPED;
    }

    protected function deleteFile(string $locale): string
    {
        $this->log('Removing the json localization file for the locale:', $locale);

        $path = $this->pathTargetFull($locale, null, true);

        if (File::exists($path)) {
            File::delete($path);

            return Status::DELETED;
        }

        return Status::SKIPPED;
    }

    protected function processor(): Processor
    {
    }
}
