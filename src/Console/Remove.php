<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Processor as ProcessorContract;
use Helldar\LaravelLangPublisher\Services\Processors\Remove as Processor;
use Helldar\LaravelLangPublisher\Support\Actions\Remove as Action;

final class Remove extends BaseCommand
{
    protected $signature = 'lang:rm'
    . ' {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Remove localizations.';

    protected $action = Action::class;

    protected function ran(): void
    {
        $this->log('Starting processing of the locales list...');

        foreach ($this->locales() as $locale) {
            $this->log('Localization handling: ' . $locale);

            $this->validateLocale($locale);

            $this->processing($locale, $locale);

            $status = $this->process(null, $locale, null);

            $this->processed($locale, $locale, $status);
        }
    }

    protected function processor(?string $filename): ProcessorContract
    {
        return Processor::make();
    }
}
