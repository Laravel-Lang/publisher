<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

class Remove extends Base
{
    protected $signature = 'lang:rm {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Remove localizations.';
}
