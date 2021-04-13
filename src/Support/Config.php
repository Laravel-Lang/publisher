<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\PrettyArray\Contracts\Caseable;
use Illuminate\Support\Facades\Config as Illuminate;

final class Config
{
    use Logger;

    public const KEY_PRIVATE = 'lang-publisher-private';

    public const KEY_PUBLIC = 'lang-publisher';

    public function basePath(): string
    {
        $this->log('Getting the path to the sources of the English localization...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.base');
    }

    public function localesPath(): string
    {
        $this->log('Getting the path to localizations...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.locales');
    }

    public function resourcesPath(): string
    {
        $this->log('Getting the path to resources...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.target');
    }

    public function hasInline(): bool
    {
        $this->log('Determines what type of files to use when updating language files...');

        return Illuminate::get(self::KEY_PUBLIC . '.inline');
    }

    public function hasAlignment(): bool
    {
        $this->log('Do arrays need to be aligned by keys before processing arrays?');

        return Illuminate::get(self::KEY_PUBLIC . '.alignment');
    }

    public function excludes(): array
    {
        $this->log('Key exclusion when combining...');

        return Illuminate::get(self::KEY_PUBLIC . '.exclude', []);
    }

    public function ignores(): array
    {
        $this->log('List of ignored localizations...');

        return Illuminate::get(self::KEY_PUBLIC . '.ignore', []);
    }

    public function getCase(): int
    {
        $this->log('Getting the value of the option to change the case of keys...');

        return Illuminate::get(self::KEY_PUBLIC . '.case', Caseable::NO_CASE);
    }

    public function defaultLocale(): string
    {
        $this->log('Obtaining a default localization key...');

        return Illuminate::get('app.locale') ?: $this->fallbackLocale();
    }

    public function fallbackLocale(): string
    {
        $this->log('Obtaining a fallback localization key...');

        return Illuminate::get('app.fallback_locale') ?: LocalesList::ENGLISH;
    }
}
