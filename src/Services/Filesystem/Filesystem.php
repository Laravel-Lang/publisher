<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\LaravelLangPublisher\Contracts\Filesystem as Contract;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\File;

abstract class Filesystem implements Contract
{
    protected function correctValues(array $items): array
    {
        return Arr::map($items, static function ($value) {
            return str_replace('\"', '"', $value);
        }, true);
    }

    protected function doesntExists(string $path): bool
    {
        return ! File::exists($path);
    }
}
