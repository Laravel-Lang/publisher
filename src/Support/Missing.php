<?php

namespace Helldar\LaravelLangPublisher\Support;

use DirectoryIterator;
use Helldar\LaravelLangPublisher\Facades\File as FileFacade;
use Helldar\LaravelLangPublisher\Facades\Locale as LocaleSupport;
use Illuminate\Support\Facades\Config as IlluminateConfig;

class Missing
{
    public function missing(): array
    {
        return array_diff($this->sourceAvailable(), $this->mainAvailable());
    }

    public function unnecessary(): array
    {
        return array_diff($this->mainAvailable(), $this->sourceAvailable());
    }

    protected function mainAvailable(): array
    {
        return LocaleSupport::availableAll();
    }

    protected function sourceAvailable(): array
    {
        $names = ['en'];

        foreach ($this->directories() as $file) {
            if (! $file->isDot() && $file->isDir()) {
                $names[] = $file->getFilename();
            }
        }

        return array_values(array_unique($names));
    }

    protected function sourcePath(): string
    {
        $path = IlluminateConfig::get(Config::KEY_PRIVATE . '.vendor');

        return rtrim($path, '/') . '/src';
    }

    /**
     * @return \DirectoryIterator|\DirectoryIterator[]
     */
    protected function directories(): DirectoryIterator
    {
        return FileFacade::files($this->sourcePath());
    }
}
