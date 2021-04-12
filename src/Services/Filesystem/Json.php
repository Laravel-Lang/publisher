<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\PrettyArray\Services\File as Pretty;
use Helldar\Support\Facades\Helpers\Arr;

final class Json extends Filesystem
{
    public function load(string $path): array
    {
        if ($this->doesntExists($path)) {
            return [];
        }

        $content = Pretty::make()->loadRaw($path);

        $items = json_decode($content, true);

        return $this->correctValues($items);
    }

    public function store(string $path, array $content)
    {
        Arr::storeAsJson($path, $content, false, JSON_UNESCAPED_UNICODE ^ JSON_PRETTY_PRINT);
    }
}
