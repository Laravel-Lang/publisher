<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Helldar\Support\Facades\Helpers\Arr;

trait Ask
{
    protected function askLocales(string $method): array
    {
        if ($locales = $this->argument('locales')) {
            return Arr::wrap($locales);
        }

        $locales = $this->confirm("Do you want to $method all localizations?") ? $this->getAllLocales() : $this->selectLocales();

        return Arr::wrap($locales);
    }

    protected function getAllLocales(): array
    {
        return Locales::available();
    }

    protected function selectLocales()
    {
        return $this->choice('What languages to add? (specify the necessary localizations separated by commas)', $this->getAllLocales(), null, null, true);
    }
}
