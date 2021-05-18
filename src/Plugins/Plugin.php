<?php

namespace Helldar\LaravelLangPublisher\Plugins;

use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Contracts\Plugin as Contract;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

abstract class Plugin implements Contract
{
    use Contains;
    use Logger;
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

    public function targetPath(string $locale, string $filename): string
    {
        $target = Path::clean(Path::target($locale));

        $path = $this->target();

        $name = $this->targetFilename($locale, $filename);

        $filename = Path::clean($path . '/' . $name, true);

        return $target . '/' . $filename;
    }

    public function targetFilename(string $locale, string $filename): string
    {
        if ($this->isJson($filename)) {
            return $locale . '.json';
        }

        return $this->fileBasename($filename);
    }

    protected function basePath(): string
    {
        return Config::basePath();
    }

    protected function fileBasename(string $filename): string
    {
        return Path::basename($filename);
    }
}
