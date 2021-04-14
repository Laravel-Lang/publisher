<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Processor as ProcessorContract;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Services\Processors\Install as Processor;
use Helldar\LaravelLangPublisher\Support\Actions\Add as Action;

final class Add extends BaseCommand
{
    protected $signature = 'lang:add'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--f|force : Override exiting files}';

    protected $description = 'Install new localizations.';

    protected $action = Action::class;

    protected function processor(): ProcessorContract
    {
        $this->log('Getting the processor: ' . Processor::class);

        return Processor::make()->force($this->hasForce());
    }

    protected function targetLocales(): array
    {
        $this->log('Getting a list of installed localizations...');

        return Locales::available();
    }
}
