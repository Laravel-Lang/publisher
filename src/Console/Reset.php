<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

class Reset extends Base
{
    protected $signature = 'lang:reset'
                           . ' {locales?* : Space-separated list of, eg: de tk it}'
                           . ' {--full : Delete custom keys}';

    protected $description = 'Resets installed locations.';

    public function handle()
    {
        // TODO: Implement handle() method.
    }
}
