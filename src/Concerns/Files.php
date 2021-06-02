<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Str;

trait Files
{
    protected $files_length = 0;

    protected $files;

    protected function files(string $package, string $locale = LocalesList::ENGLISH): array
    {
        $this->log('Getting a list of files for the ', $package, 'package...');

        if ($this->files[$package] ?? false) {
            return $this->files[$package];
        }

        $path = $this->pathSource($package, $locale);

        return $this->files[$package] = File::names($path, static function ($filename) {
            return ! Str::contains($filename, ['inline', 'json']);
        });
    }

    protected function filesLength(): int
    {
        $this->log('Getting the maximum length of a filenames...');

        if ($this->files_length > 0) {
            return $this->files_length;
        }

        $this->log('Calculating the maximum length of a filenames...');

        $files = [];

        foreach ($this->packages() as $package) {
            $files = array_merge($files, $this->files($package));

            foreach ($this->plugins() as $plugin) {
                if ($plugin->has()) {
                    $files = array_merge($files, $plugin->source());
                }
            }
        }

        return $this->files_length = Arr::longestStringLength(array_unique($files));
    }
}
