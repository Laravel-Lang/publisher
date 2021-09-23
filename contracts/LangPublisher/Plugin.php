<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

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
