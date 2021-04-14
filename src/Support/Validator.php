<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Exceptions\PackageDoesntExistsException;
use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleDoesntExistsException;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;
use Helldar\LaravelLangPublisher\Facades\Locales as LocalesFacade;

class Validator
{
    use Logger;

    /**
     * Checking for localization existence.
     *
     * @param  string  $locale
     */
    public function locale(string $locale): void
    {
        $this->log('Checking for localization existence: ' . $locale);

        if (! LocalesFacade::isAvailable($locale)) {
            throw new SourceLocaleDoesntExistsException($locale);
        }
    }

    public function package(string $package): void
    {
        $this->log('Checking for package existence: ' . $package);

        if (! in_array($package, ConfigFacade::packages(), true)) {
            throw new PackageDoesntExistsException($package);
        }
    }
}
