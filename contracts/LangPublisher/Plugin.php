<?php

declare(strict_types=1);

namespace Helldar\Contracts\LangPublisher;

interface Plugin
{
    /**
     * Specifies the namespace of the package, upon detection
     * of which the localization will be installed.
     *
     * Leave blank if you always need to install the localization.
     *
     * @return string
     */
    public function vendor(): string;

    /**
     * Specifies the relative path to the source files.
     *
     * @return array
     */
    public function files(): array;

    /**
     * Determines the existence of a vendor in the application.
     *
     * @return bool
     */
    public function has(): bool;
}
