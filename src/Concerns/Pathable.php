<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Path;

trait Pathable
{
    protected function pathSource(string $package, string $locale): string
    {
        return Path::source($package, $locale);
    }

    protected function pathTarget(string $locale, bool $is_json = false): string
    {
        return Path::target($locale, $is_json);
    }

    protected function pathTargetFull(string $locale, ?string $filename, bool $is_json = false): string
    {
        return Path::targetFull($locale, $filename, $is_json);
    }

    protected function pathLocales(string $package, string $locale = null): string
    {
        return Path::locales($package, $locale);
    }

    protected function pathDirectory(string $path): string
    {
        return Path::directory($path);
    }

    protected function pathFilename(string $path): string
    {
        return Path::filename($path);
    }

    protected function pathExtension(string $path): string
    {
        return Path::extension($path);
    }
}
