<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Contracts\Package;
use Helldar\LaravelLangPublisher\Facades\Config;
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

    protected function pathTargetPackage(string $locale, Package $package): string
    {
        $this->log('Retrieving a link to the target file for the', $locale, 'localization (', get_class($package), ')...');

        $resources = Path::target($locale, true);

        $path = $package->target();

        $filename = $locale . '.json';

        return $resources . '/' . $path . '/' . $filename;
    }

    protected function pathLocales(string $package, string $locale = null): string
    {
        $this->log('Getting the path to excluding English localization: ' . $locale);

        return Path::locales($package, $locale);
    }

    protected function pathVendor(): string
    {
        $this->log('Getting the vendor path.');

        return Config::basePath();
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
