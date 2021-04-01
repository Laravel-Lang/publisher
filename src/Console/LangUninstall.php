<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Services\Processors\DeleteJson;
use Helldar\LaravelLangPublisher\Services\Processors\DeletePhp;

final class LangUninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--j|json : Uninstall JSON files}'
    . ' {--jet : Uninstall Jetstream JSON files. This is an alias for "--json" key. }'
    . ' {--fortify : Uninstall Fortify JSON files. This is an alias for "--json" key. }'
    . ' {--cashier : Uninstall Cashier JSON files. This is an alias for "--json" key. }'
    . ' {--nova : Uninstall Nova JSON files. This is an alias for "--json" key. }';

    protected $description = 'Uninstall localizations.';

    protected $action = 'uninstall';

    public function handle()
    {
        $this->setProcessor(DeletePhp::class, DeleteJson::class);

        $this->exec($this->installed());

        $this->result
            ->setMessage('No uninstalled localizations.')
            ->show();
    }
}
