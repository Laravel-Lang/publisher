<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Localization;
use Illuminate\Console\Command;

class LangInstall extends Command
{
    protected $signature = 'lang:install'
    . ' {lang* : Lang files to copy}'
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
        $languages = (array) $this->argument('lang');
        $force     = (bool) $this->option('force');

        foreach ($languages as $lang) {
            $this->localization->publish($lang, $force);
        }

        $this->showResult();
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
