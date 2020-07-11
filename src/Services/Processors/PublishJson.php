<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Traits\Processors\Publishable;
use SplFileInfo;

final class PublishJson extends BaseProcessor
{
    use Publishable;

    protected $extension = 'json';

    protected function publish(): void
    {
        $this->publishFile(
            new SplFileInfo($this->sourcePath())
        );
    }

    protected function excluded(array $array, string $key): array
    {
        $keys = Config::getExclude($key, [], true);

        return array_filter($array, static function ($value) use ($keys) {
            return in_array($value, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }
}
