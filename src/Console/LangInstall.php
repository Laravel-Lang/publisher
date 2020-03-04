<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Localization;
use Helldar\LaravelLangPublisher\Facades\Locale;

class LangInstall extends BaseCommand
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
        $this->showResult($this->localization->getResult(), 'Files were not copied.');
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
}
