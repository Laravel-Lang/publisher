<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\PublishJson as PublishJsonProcessor;
use Helldar\LaravelLangPublisher\Services\Processors\PublishPhp as PublishPhpProcessor;

final class LangInstall extends BaseCommand
{
    protected $signature = 'lang:install'
    . ' {locales* : Space-separated list of, eg: de tk it}'
    . ' {--f|force : Override exiting files}'
    . ' {--j|json : Install JSON files}';

    protected $description = 'Install new localizations.';

    protected $process_php = PublishPhpProcessor::class;

    protected $process_json = PublishJsonProcessor::class;

    public function handle()
    {
        $this->exec(
            Locale::available()
        );

        $this->result
            ->setMessage('Files were not copied.')
            ->show();
    }
}
