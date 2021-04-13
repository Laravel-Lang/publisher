<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Processor as ProcessorContract;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Services\Processors\Install as Processor;
use Helldar\LaravelLangPublisher\Support\Actions\Update as Action;

final class Update extends BaseCommand
{
    protected $signature = 'lang:update';

    protected $description = 'Updating installed localizations.';

    protected $action = Action::class;

    protected function ran(): void
    {
        $this->locales = Locales::installed();

        parent::ran();
    }

    protected function processor(): ProcessorContract
    {
        $this->log('Getting the processor: ' . Processor::class);

        return Processor::make()->force(true);
    }
}
