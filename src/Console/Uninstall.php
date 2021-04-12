<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Services\Processors\Uninstall as Processor;

final class Uninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall'
    . ' {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Uninstall localizations.';

    protected $action = 'uninstall';

    protected function process(string $locale, string $source_path, string $target_path): void
    {
        Processor::make()
            ->source($source_path)
            ->target($target_path)
            ->run();
    }
}
