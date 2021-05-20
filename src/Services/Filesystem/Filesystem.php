<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Contracts\Filesystem as Contract;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Filesystem\File;

abstract class Filesystem implements Contract
{
    use Logger;

    protected function correctValues(array $items): array
    {
        $this->log('Correcting array values...');

        $callback = static function ($value) {
            return stripslashes($value);
        };

        return Arrayable::of($items)
            ->map($callback, true)
            ->renameKeys($callback)
            ->get();
    }

    protected function doesntExists(string $path): bool
    {
        $this->log('Checking for the existence of a path:', $path);

        return ! File::exists($path);
    }
}
