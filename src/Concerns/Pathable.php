<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Path;

trait Pathable
{
    protected function pathSource(string $package, string $locale): string
    {
        $this->log('Retrieving a link to the source directory for the', $package, 'package and the', $locale, 'localization...');

        return Path::source($package, $locale);
    }

    protected function pathTarget(string $locale, bool $is_json = false): string
    {
        $this->log('Retrieving a link to the target directory for the', $locale, '(is json:', $is_json, ') localization...');

        return Path::target($locale, $is_json);
    }

    protected function pathTargetFull(string $locale, ?string $filename, bool $is_json = false): string
    {
        $this->log('Retrieving a link to the target file for the', $locale, '(is json:', $is_json, ') localization, filename is ', $filename, '...');

        return Path::targetFull($locale, $filename, $is_json);
    }

    protected function pathLocales(string $package, string $locale = null): string
    {
        $this->log('Getting the path to excluding English localization: ' . $locale);

        return Path::locales($package, $locale);
    }

    protected function pathFilename(string $path): string
    {
        $this->log('Getting file name without extension:', $path);

        return Path::filename($path);
    }

    protected function pathExtension(string $path): string
    {
        $this->log('Getting file extension:', $path);

        return Path::extension($path);
    }
}
