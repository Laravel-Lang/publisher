<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Processor as ProcessorContract;
use Helldar\LaravelLangPublisher\Services\Processors\Install as Processor;
use Helldar\LaravelLangPublisher\Support\Actions\Update as Action;

final class Update extends BaseCommand
{
    protected $signature = 'lang:update';

    protected $description = 'Updating installed localizations.';

    protected $action = Action::class;

    protected function processor(?string $filename): ProcessorContract
    {
        $this->log('Getting the processor:', Processor::class);

        $has_force = $this->hasForce() || $this->hasProcessed($filename);

        return Processor::make()->force($has_force);
    }

    protected function locales(): array
    {
        $this->log('Getting a list of installed localizations...');

        return $this->targetLocales();
    }

    protected function hasForce(): bool
    {
        return true;
    }
}
