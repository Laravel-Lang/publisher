<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Plugins;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;

abstract class Plugin
{
    protected ?string $vendor = null;

    protected string $version = '*';

    protected bool $with_project_name = false;

    abstract public function files(): array;

    public function vendor(): ?string
    {
        return $this->vendor;
    }

    public function has(): bool
    {
        if ($this->hasProjectName()) {
            return true;
        }

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
            return InstalledVersions::satisfies(new VersionParser, $vendor, $this->version);
        }

        return true;
    }

    private function hasProjectName(): bool
    {
        if (! $this->with_project_name || ! $this->vendor()) {
            return false;
        }

        return $this->vendor === (InstalledVersions::getRootPackage()['name'] ?? false);
    }
}
