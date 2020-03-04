<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Localization;
use Helldar\LaravelLangPublisher\Facades\Locale;
use Illuminate\Console\Command;

class LangInstall extends Command
{
    protected $signature = 'lang:install'
    . ' {locales* : Localizations to copy}'
    . ' {--f|force : Force replace lang files}';

    protected $description = 'Install new localizations.';

    /** @var \Helldar\LaravelLangPublisher\Contracts\Localization */
    protected $localization;

    public function __construct(Localization $localization)
    {
        parent::__construct();

        $this->localization = $localization;
    }

    public function handle()
    {
        $locales = (array) $this->argument('locales');
        $force   = (bool) $this->option('force');

        $this->install($locales, $force);
        $this->showResult();
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
            $this->localization->publish($locale, $force);
        }
    }

    protected function showResult(): void
    {
        if (empty($this->localization->getResult())) {
            $this->warn('Files were not copied.');

            return;
        }

        $this->table(['Locale', 'Filename', 'Status'], $this->localization->getResult());
    }
}
