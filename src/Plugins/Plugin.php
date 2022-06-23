<?php

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
