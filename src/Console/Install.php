<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Services\Processors\Install as Processor;

final class Install extends BaseCommand
{
    protected $signature = 'lang:install'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--f|force : Override exiting files}';

    protected $description = 'Install new localizations.';

    protected function process(string $locale, string $source_path, string $target_path): void
    {
        Processor::make()
            ->source($source_path)
            ->target($target_path)
            ->run();
    }
}
