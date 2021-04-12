<?php

namespace Helldar\LaravelLangPublisher\Console;

final class Uninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall'
    . ' {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Uninstall localizations.';

    protected $action = 'uninstall';

    public function handle()
    {
        $this->exec($this->installed());

        $this->result
            ->setMessage('No uninstalled localizations.')
            ->show();
    }
}
