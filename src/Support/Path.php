<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Contracts\Path as PathContract;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;

use function ltrim;
use function realpath;
use function resource_path;

class Path implements PathContract
{
    public function source(string $locale = null, string $filename = null): string
    {
        $locale   = $this->getPathForEnglish($locale);
        $locale   = $this->clean($locale);
        $filename = $this->clean($filename);

        return $this->real(
            ConfigFacade::getVendorPath() . $locale . $filename
        );
    }

    public function target(string $locale = null, string $filename = null): string
    {
        $locale   = $this->clean($locale);
        $filename = $this->clean($filename);

        return resource_path(static::LANG . $locale . $filename);
    }

    protected function real(string $path): string
    {
        return realpath($path);
    }

    protected function clean(string $path = null): ?string
    {
        return $path
            ? static::DIVIDER . ltrim($path, static::DIVIDER)
            : $path;
    }

    protected function getPathForEnglish(string $locale): string
    {
        return $locale === 'en'
            ? '../script/en'
            : $locale;
    }
}
