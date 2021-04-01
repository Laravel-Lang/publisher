<?php

namespace Helldar\LaravelLangPublisher\Console;

final class LangUpdate extends BaseCommand
{
    protected $signature = 'lang:update'
    . ' {--j|json : Update JSON files}'
    . ' {--jet : Update Jetstream JSON files. This is an alias for "--json" key. }'
    . ' {--fortify : Update Fortify JSON files. This is an alias for "--json" key. }'
    . ' {--cashier : Update Cashier JSON files. This is an alias for "--json" key. }'
    . ' {--nova : Update Nova JSON files. This is an alias for "--json" key. }';

    protected $description = 'Updating installed localizations.';

    public function handle()
    {
        $this->call('lang:install', [
            'locales' => $this->installed(),
            '--force' => true,
            '--json'  => $this->wantsJson(),
        ]);
    }
}
