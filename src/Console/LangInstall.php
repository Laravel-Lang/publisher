<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\PublishJson;
use Helldar\LaravelLangPublisher\Services\Processors\PublishPhp;

final class LangInstall extends BaseCommand
{
    protected $signature = 'lang:install'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--f|force : Override exiting files}'
    . ' {--j|json : Install JSON files}';

    protected $description = 'Install new localizations.';

    public function handle()
    {
        $this->setProcessor(PublishPhp::class, PublishJson::class);

        $this->exec(
            Locale::available($this->wantsJson())
        );

        $this->result
            ->setMessage('Files were not copied.')
            ->show();
    }
}
