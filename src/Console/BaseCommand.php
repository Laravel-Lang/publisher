<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Str;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    use Logger;

    public function handle()
    {
        foreach ($this->locales() as $locale) {
            foreach ($this->files() as $filename) {
                $source = $this->sourcePath($locale, $filename);
                $target = $this->targetPath($locale, $filename);

                $this->process($locale, $source, $target);
            }
        }
    }

    abstract protected function process(string $locale, string $source_path, string $target_path): void;

    protected function installed(): array
    {
        return Locales::installed();
    }

    protected function sourcePath(string $locale, string $filename): string
    {
        return Path::source($locale . '/' . $filename);
    }

    protected function targetPath(string $locale, string $filename): string
    {
        return Path::target(implode('/', $params));
    }

    protected function files(): array
    {
        return File::names($this->sourcePath(LocalesList::ENGLISH), static function ($filename) {
            return ! Str::contains($filename, 'inline');
        });
    }

    protected function locales(): array
    {
        return (array) $this->argument('locales');
    }
}
