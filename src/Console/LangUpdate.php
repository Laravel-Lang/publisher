<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;

final class LangUpdate extends BaseCommand
{
    protected $signature = 'lang:update'
    . ' {--j|json : Install JSON files}';

    protected $description = 'Updating installed localizations.';

    public function handle()
    {
        $this->call('lang:install', [
            'locales' => Locale::installed(),
            '--force' => true,
            '--json'  => $this->json(),
        ]);
    }
}
