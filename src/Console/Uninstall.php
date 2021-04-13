<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Processor as ProcessorContract;
use Helldar\LaravelLangPublisher\Services\Processors\Uninstall as Processor;
use Helldar\LaravelLangPublisher\Support\Actions\Uninstall as Action;

final class Uninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall'
    . ' {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Uninstall localizations.';

    protected $action = Action::class;

    protected function processor(): ProcessorContract
    {
        $this->log('Getting the processor: ' . Processor::class);

        return Processor::make();
    }
}
