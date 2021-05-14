<?php

namespace Helldar\LaravelLangPublisher\Packages;

use Helldar\LaravelLangPublisher\Contracts\Package as Contract;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

abstract class Package implements Contract
{
    use Makeable;

    public function target(): string
    {
        return '/';
    }

    public function has(string $package = null, string $locale = null): bool
    {
        return Directory::exists($this->basePath() . '/' . $this->vendor());
    }

    public function sourcePath(string $package, string $locale): string
    {
        $path = Path::source($package, $locale);

        return $path . '/' . $this->source();
    }

    public function targetPath(string $locale): string
    {
        $target = Path::clean(Path::target($locale));

        $path = $this->target();

        $filename = Path::clean($path . '/' . $locale . '.json', true);

        return $target . '/../' . $filename;
    }

    protected function basePath(): string
    {
        return Config::basePath();
    }
}
