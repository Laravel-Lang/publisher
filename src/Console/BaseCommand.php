<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Services\Localization;
use Helldar\LaravelLangPublisher\Support\Result;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    /** @var \Helldar\LaravelLangPublisher\Services\Localization */
    protected $localization;

    /** @var \Helldar\LaravelLangPublisher\Support\Result */
    protected $result;

    public function __construct(Localization $localization, Result $result)
    {
        parent::__construct();

        $this->localization = $localization;

        $this->result = $result->setOutput($this);
    }

    protected function locales(): array
    {
        return (array) $this->argument('locales');
    }

    protected function isForce(): bool
    {
        return (bool) $this->option('force');
    }

    protected function isJson(): bool
    {
        return (bool) $this->option('json');
    }
}
