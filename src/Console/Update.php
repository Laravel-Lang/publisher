<?php

namespace Helldar\LaravelLangPublisher\Console;

final class Update extends BaseCommand
{
    protected $signature = 'lang:update';

    protected $description = 'Updating installed localizations.';

    public function handle()
    {
        $this->call('lang:install', [
            'locales' => $this->installed(),
            '--force' => true,
        ]);
    }
}
