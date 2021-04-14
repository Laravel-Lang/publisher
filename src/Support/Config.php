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

    public function packages(): array
    {
        $this->log('Getting a list of supported packages...');

        return Illuminate::get(self::KEY_PRIVATE . '.packages');
    }

    /**
     * Getting the path to the sources of the English localization.
     *
     * @return string
     */
    public function basePath(): string
    {
        $this->log('Getting the path to the sources of the English localization...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.base');
    }

    /**
     * Getting the path to source locale.
     *
     * @return string
     */
    public function sourcePath(): string
    {
        $this->log('Getting the path to source locale...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.source');
    }

    /**
     * Getting the path to localizations.
     *
     * @return string
     */
    public function localesPath(): string
    {
        $this->log('Getting the path to localizations...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.locales');
    }

    /**
     * Getting the path to resources of the application.
     *
     * @return string
     */
    public function resourcesPath(): string
    {
        $this->log('Getting the path to resources of the application...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.target');
    }

    /**
     * Determines what type of files to use when updating language files.
     *
     * @return bool
     */
    public function hasInline(): bool
    {
        $this->log('Determines what type of files to use when updating language files...');

        return Illuminate::get(self::KEY_PUBLIC . '.inline');
    }

    /**
     * Determines whether values should be aligned when saving.
     *
     * @return bool
     */
    public function hasAlignment(): bool
    {
        $this->log('Determines whether values should be aligned when saving...');

        return Illuminate::get(self::KEY_PUBLIC . '.alignment');
    }

    /**
     * Key exclusion when combining.
     *
     * @return array
     */
    public function excludes(): array
    {
        $this->log('Key exclusion when combining...');

        return Illuminate::get(self::KEY_PUBLIC . '.exclude', []);
    }

    /**
     * List of ignored localizations.
     *
     * @return array
     */
    public function ignores(): array
    {
        $this->log('List of ignored localizations...');

        return Illuminate::get(self::KEY_PUBLIC . '.ignore', []);
    }

    /**
     * Getting the value of the option to change the case of keys.
     *
     * @return int
     */
    public function getCase(): int
    {
        $this->log('Getting the value of the option to change the case of keys...');

        return Illuminate::get(self::KEY_PUBLIC . '.case', Caseable::NO_CASE);
    }

    /**
     * Getting the default localization name.
     *
     * @return string
     */
    public function defaultLocale(): string
    {
        $this->log('Getting the default localization name...');

        return Illuminate::get('app.locale') ?: $this->fallbackLocale();
    }

    /**
     * Getting the fallback localization name.
     *
     * @return string
     */
    public function fallbackLocale(): string
    {
        $this->log('Getting the fallback localization name...');

        return Illuminate::get('app.fallback_locale') ?: LocalesList::ENGLISH;
    }
}
