<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\File;
use Helldar\LaravelLangPublisher\Traits\Processors\Publishable;
use SplFileInfo;

final class ResetJson extends BaseProcessor
{
    use Publishable;

    protected $extension = 'json';

    protected function publish(): void
    {
        $this->resetFile(
            new SplFileInfo($this->sourcePath())
        );
    }

    protected function excluded(array $array, string $filename): array
    {
        $key  = File::name($filename);
        $keys = Config::getExclude($key, [], true);

        return array_filter($array, static function ($value) use ($keys) {
            return in_array($value, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }
}
