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
        $this->localization = $localization;

        parent::__construct();
    }

    public function handle()
    {
        $languages = (array) $this->argument('lang');
        $force     = (bool) $this->option('force');

        foreach ($languages as $lang) {
            $this->localization->publish($lang, $force);
        }

        $this->showCopied();
        $this->showSkipped();
    }

    protected function showCopied(): void
    {
        if (empty($this->localization->getCopied())) {
            $this->warn('Files were not copied.');

            return;
        }

        $this->info('TODO: show copied files.');
    }

    protected function showSkipped(): void
    {
        if (empty($this->localization->getSkipped())) {
            return;
        }

        $this->info('TODO: show skipped files.');
    }
}
