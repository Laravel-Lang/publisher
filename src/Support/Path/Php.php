<?php

namespace Helldar\LaravelLangPublisher\Support\Path;

use Helldar\LaravelLangPublisher\Facades\Config;

final class Php extends BasePath
{
    /**
     * Returns a direct link to the folder with the source localization files.
     *
     * If the file name is specified, a full link to the file will be returned,
     * otherwise a direct link to the folder.
     *
     * @param  string|null  $locale
     *
     * @return string
     */
    public function source(string $locale = null): string
    {
        $locale = $this->clean(
            $this->getPathForEnglish($locale)
        );

        return $this->real(
            Config::getVendorPath() . $locale
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
}
