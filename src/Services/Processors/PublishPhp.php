<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\File;
use Helldar\LaravelLangPublisher\Traits\Processors\Publishable;
use Illuminate\Support\Arr;

final class PublishPhp extends BaseProcessor
{
    use Publishable;

    protected function publish(): void
    {
        $this->checkExists($this->sourcePath());

        foreach (File::files($this->sourcePath()) as $file) {
            $this->publishFile($file);
        }
    }

    protected function excluded(array $array, string $filename): array
    {
        $key  = File::name($filename);
        $keys = Config::getExclude($key, []);

        return Arr::only($array, $keys);
    }
}
