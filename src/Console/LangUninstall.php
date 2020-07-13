<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\DeleteJson;
use Helldar\LaravelLangPublisher\Services\Processors\DeletePhp;

final class LangUninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall'
    . ' {locales? : Space-separated list of, eg: de tk it}'
    . ' {--j|json : Install JSON files}';

    protected $description = 'Uninstall localizations.';

    protected $action = 'uninstall';

    public function handle()
    {
        $this->setProcessor(DeletePhp::class, DeleteJson::class);

        $this->exec(
            Locale::installed($this->wantsJson())
        );

        $this->result
            ->setMessage('No uninstalled localizations.')
            ->show();
    }
}
