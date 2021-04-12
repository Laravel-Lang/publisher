<?php

namespace Helldar\LaravelLangPublisher\Console;

final class Install extends BaseCommand
{
    protected $signature = 'lang:install'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--f|force : Override exiting files}';

    protected $description = 'Install new localizations.';

    public function handle()
    {
        $this->exec($this->available());

        $this->result
            ->setMessage('Files were not copied.')
            ->show();
    }
}
