<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Services\Processors\ResetJson;
use Helldar\LaravelLangPublisher\Services\Processors\ResetPhp;

final class LangReset extends BaseCommand
{
    protected $signature = 'lang:reset'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--j|json : Reset JSON files}'
    . ' {--jet : Reset Jetstream JSON files. This is an alias for "--json" key. }'
    . ' {--fortify : Reset Fortify JSON files. This is an alias for "--json" key. }'
    . ' {--cashier : Reset Cashier JSON files. This is an alias for "--json" key. }'
    . ' {--nova : Reset Nova JSON files. This is an alias for "--json" key. }'
    . ' {--f|full : Reset files without excluded keys}';

    protected $description = 'Resets installed locations.';

    protected $action = 'reset';

    protected $action_default = true;

    public function handle()
    {
        $this->setProcessor(ResetPhp::class, ResetJson::class);

        $this->exec($this->installed());

        $this->result
            ->setMessage('Files have not been reset.')
            ->show();
    }
}
