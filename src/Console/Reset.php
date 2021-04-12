<?php

namespace Helldar\LaravelLangPublisher\Console;

final class Reset extends BaseCommand
{
    protected $signature = 'lang:reset'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--f|full : Reset files without excluded keys}';

    protected $description = 'Resets installed locations.';

    protected $action = 'reset';

    protected $action_default = true;

    public function handle()
    {
        $this->exec($this->installed());

        $this->result
            ->setMessage('Files have not been reset.')
            ->show();
    }
}
