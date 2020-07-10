<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\DeleteJson as DeleteJsonProcessor;
use Helldar\LaravelLangPublisher\Services\Processors\DeletePhp as DeletePhpProcessor;

final class LangUninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall'
    . ' {locales* : Space-separated list of, eg: de tk it}'
    . ' {--j|json : Install JSON files}';

    protected $description = 'Uninstall localizations.';

    protected $process_php = DeletePhpProcessor::class;

    protected $process_json = DeleteJsonProcessor::class;

    public function handle()
    {
        $this->exec(
            Locale::installed()
        );

        $this->result
            ->setMessage('No uninstalled localizations.')
            ->show();
    }
}
