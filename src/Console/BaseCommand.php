<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Services\Localization;
use Helldar\LaravelLangPublisher\Support\Result;
use Helldar\LaravelLangPublisher\Traits\Containable;
use Helldar\LaravelLangPublisher\Traits\Containers\Pathable;
use Helldar\LaravelLangPublisher\Traits\Containers\Processable;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    use Containable;
    use Processable;
    use Pathable;

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

    protected function exec(array $locales): void
    {
        foreach ($this->getLocales($locales) as $locale) {
            $this->result->merge(
                $this->localization
                    ->setPath($this->getPath())
                    ->setProcessor($this->getProcessor())
                    ->run($locale, $this->isForce())
            );
        }
    }

    protected function getLocales(array $locales): array
    {
        return $this->locales() === ['*']
            ? $locales
            : $this->locales();
    }
}
