<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Processor as ProcessorContract;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Services\Processors\Reset as Processor;
use Helldar\LaravelLangPublisher\Support\Actions\Reset as Action;

final class Reset extends BaseCommand
{
    protected $signature = 'lang:reset'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--f|full : Reset files without excluded keys}';

    protected $description = 'Resets installed locations.';

    protected $action = Action::class;

    protected function processor(): ProcessorContract
    {
        return Processor::make()->full($this->hasFull());
    }

    protected function targetLocales(): array
    {
        return Locales::installed();
    }
}
