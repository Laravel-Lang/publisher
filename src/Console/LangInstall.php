<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;

final class LangInstall extends BaseCommand
{
    protected $signature = 'lang:install'
    . ' {locales* : Localizations to copy}'
    . ' {--f|force : Force replace lang files}'
    . ' {--j|json : Install JSON files}';

    protected $description = 'Install new localizations.';

    public function handle()
    {
        $this->install(
            $this->locales(),
            $this->force(),
            $this->json()
        );

        $this->result
            ->setMessage('Files were not copied.')
            ->show();
    }

    protected function install(array $locales, bool $force = false, bool $json = false): void
    {
        $locales === ['*']
            ? $this->installSome(Locale::available(), $force, $json)
            : $this->installSome($locales, $force, $json);
    }

    protected function installSome(array $locales, bool $force = false, bool $json = false): void
    {
        foreach ($locales as $locale) {
            $this->result->merge(
                $this->localization->publish($locale, $force, $json)
            );
        }
    }
}
