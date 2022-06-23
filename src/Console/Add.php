<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

class Add extends Base
{
    protected $signature = 'lang:add {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Install new localizations.';

    public function handle()
    {

    }
}
