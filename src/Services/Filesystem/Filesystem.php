<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Contracts\Filesystem as Contract;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\File;

abstract class Filesystem implements Contract
{
    use Logger;

    protected function correctValues(array $items): array
    {
        $this->log('Correcting array values...');

        return Arr::map($items, static function ($value) {
            return str_replace('\"', '"', $value);
        }, true);
    }

    protected function doesntExists(string $path): bool
    {
        $this->log('Checking for the existence of a path:', $path);

        return ! File::exists($path);
    }
}
