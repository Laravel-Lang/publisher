<?php

/*
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

namespace LaravelLang\Publisher\Plugins;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;

abstract class Plugin
{
    abstract public function files(): array;

    public function vendor(): ?string
    {
        return null;
    }

    public function version(): string
    {
        return '*';
    }

    public function has(): bool
    {
        return $this->hasVendor() && $this->hasVersion();
    }

    private function hasVendor(): bool
    {
        if ($vendor = $this->vendor()) {
            return InstalledVersions::isInstalled($vendor);
        }

        return true;
    }

    private function hasVersion(): bool
    {
        if ($vendor = $this->vendor()) {
            return InstalledVersions::satisfies(new VersionParser(), $vendor, $this->version());
        }

        return true;
    }
}
