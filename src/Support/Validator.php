<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Concerns\Pathable;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Exceptions\PackageDoesntExistsException;
use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleDoesntExistsException;
use Helldar\LaravelLangPublisher\Facades\Locales as LocalesFacade;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

class Validator
{
    use Logger;
    use Pathable;

    /**
     * Checking for localization existence.
     *
     * @param  string  $locale
     */
    public function locale(string $locale): void
    {
        $this->log('Checking for localization existence:', $locale);

        if (! LocalesFacade::isAvailable($locale)) {
            throw new SourceLocaleDoesntExistsException($locale);
        }
    }

    public function package(string $package): void
    {
        $this->log('Checking for package existence:', $package);

        $source  = $this->pathSource($package, LocalesList::ENGLISH);
        $locales = $this->pathLocales($package);

        if (Directory::doesntExist($source) || Directory::doesntExist($locales)) {
            throw new PackageDoesntExistsException($package);
        }
    }
}
