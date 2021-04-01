<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Services\Processors\PublishJson;
use Helldar\LaravelLangPublisher\Services\Processors\PublishPhp;

final class LangInstall extends BaseCommand
{
    protected $signature = 'lang:install'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--f|force : Override exiting files}'
    . ' {--j|json : Install JSON files}'
    . ' {--jet : Install Jetstream JSON files. This is an alias for "--json" key. }'
    . ' {--fortify : Install Fortify JSON files. This is an alias for "--json" key. }'
    . ' {--cashier : Install Cashier JSON files. This is an alias for "--json" key. }'
    . ' {--nova : Install Nova JSON files. This is an alias for "--json" key. }';

    protected $description = 'Install new localizations.';

    public function handle()
    {
        $this->setProcessor(PublishPhp::class, PublishJson::class);

        $this->exec($this->available());

        $this->result
            ->setMessage('Files were not copied.')
            ->show();
    }
}
