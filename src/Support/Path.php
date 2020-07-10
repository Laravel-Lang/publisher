<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;

use function ltrim;
use function realpath;
use function resource_path;

final class Path
{
    public const DIVIDER = DIRECTORY_SEPARATOR;

    public const LANG = 'lang';

    /**
     * Returns a direct link to the folder with the source localization files.
     *
     * If the file name is specified, a full link to the file will be returned,
     * otherwise a direct link to the folder.
     *
     * @param  string|null  $locale
     * @param  string|null  $filename
     *
     * @return string
     */
    public function source(string $locale = null, string $filename = null): string
    {
        $locale   = $this->getPathForEnglish($locale);
        $locale   = $this->clean($locale);
        $filename = $this->clean($filename);

        return $this->real(
            ConfigFacade::getVendorPath() . $locale . $filename
        );
    }

    /**
     * Returns the direct link to the localization folder or,
     * if the file name is specified, a link to the localization file.
     *
     * If the file name or localization is not specified,
     * the link to the shared folder of all localizations will be returned.
     *
     * @param  string|null  $locale
     * @param  string|null  $filename
     *
     * @return string
     */
    public function target(string $locale = null, string $filename = null): string
    {
        $locale   = $this->clean($locale);
        $filename = $this->clean($filename);

        return resource_path(self::LANG . $locale . $filename);
    }

    protected function real(string $path): string
    {
        return realpath($path);
    }

    protected function clean(string $path = null): ?string
    {
        return $path
            ? self::DIVIDER . ltrim($path, self::DIVIDER)
            : $path;
    }

    protected function getPathForEnglish(string $locale): string
    {
        return $locale === 'en'
            ? '../script/en'
            : $locale;
    }
}
