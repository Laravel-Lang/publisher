<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;

final class LangUpdate extends BaseCommand
{
    protected $signature = 'lang:update'
    . ' {--j|json : Update JSON files}'
    . ' {--jet : Update Jetstream JSON files. This is an alias for "--json" key. }'
    . ' {--fortify : Update Fortify JSON files. This is an alias for "--json" key. }';

    protected $description = 'Updating installed localizations.';

    public function handle()
    {
        $this->call('lang:install', [
            'locales'   => Locale::installed($this->wantsJson()),
            '--force'   => true,
            '--json'    => $this->wantsJson(),
            '--jet'     => $this->wantsJson(),
            '--fortify' => $this->wantsJson(),
        ]);
    }
}
