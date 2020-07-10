<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;

final class LangInstall extends BaseCommand
{
    protected $signature = 'lang:install'
    . ' {locales* : Comma-separated list of, eg: de,tk,it}'
    . ' {--f|force : Override exiting files}';

    protected $description = 'Install new localizations.';

    public function handle()
    {
        $this->install(
            $this->locales(),
            $this->force()
        );

        $this->result
            ->setMessage('Files were not copied.')
            ->show();
    }

    protected function install(array $locales, bool $force = false): void
    {
        $locales === ['*']
            ? $this->installSome(Locale::available(), $force)
            : $this->installSome($locales, $force);
    }

    protected function installSome(array $locales, bool $force = false): void
    {
        foreach ($locales as $locale) {
            $this->result->merge(
                $this->localization->publish($locale, $force)
            );
        }
    }
}
