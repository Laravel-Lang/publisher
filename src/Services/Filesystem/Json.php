<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\PrettyArray\Services\File as Pretty;
use Helldar\Support\Facades\Helpers\Arr;

final class Json extends Filesystem
{
    public function load(string $path): array
    {
        $this->log('Loading the contents of the file:', $path);

        if ($this->doesntExists($path)) {
            $this->log('File not found:', $path);

            return [];
        }

        $this->log('Loading data from a file:', $path);

        $content = Pretty::make()->loadRaw($path);

        $items = json_decode($content, true);

        return $this->correctValues($items);
    }

    public function store(string $path, array $content)
    {
        $this->log('Saving an array to a file:', $path);

        Arr::storeAsJson($path, $content, false, JSON_UNESCAPED_UNICODE ^ JSON_PRETTY_PRINT);
    }
}
