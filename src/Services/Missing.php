<?php

namespace Helldar\LaravelLangPublisher\Services;

use Helldar\LaravelLangPublisher\Facades\Arr as ArrFacade;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

final class Missing
{
    public function missing(): array
    {
        return array_diff($this->available(), $this->main());
    }

    public function unnecessary(): array
    {
        return array_diff($this->main(), $this->available());
    }

    protected function main(): array
    {
        return Locales::available(true);
    }

    protected function available(): array
    {
        $locales = ArrFacade::unique(array_merge(['en'], $this->locales()));

        $sorted = Arr::sort($locales);

        return array_values($sorted);
    }

    protected function locales(): array
    {
        return Directory::names($this->path());
    }

    protected function path(): string
    {
        return Config::localesPath();
    }
}
