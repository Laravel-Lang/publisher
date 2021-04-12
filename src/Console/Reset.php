<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Services\Processors\Reset as Processor;

final class Reset extends BaseCommand
{
    protected $signature = 'lang:reset'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--f|full : Reset files without excluded keys}';

    protected $description = 'Resets installed locations.';

    protected $action = 'reset';

    protected function process(string $locale, string $source_path, string $target_path): void
    {
        Processor::make()
            ->source($source_path)
            ->target($target_path)
            ->run();
    }
}
