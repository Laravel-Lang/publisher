<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\PrettyArray\Services\File as Pretty;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Arr;

final class Json extends Filesystem
{
    public function load(string $path, string $main_path = null): array
    {
        $this->log('Loading the contents of the file:', $path, '(', $main_path, ')');

        if ($this->doesntExists($path) || ($main_path && $this->doesntExists($main_path))) {
            $path = $this->doesntExists($path) ? $path : $main_path;

            $this->log('File not found:', $path);

            return [];
        }

        if (! empty($path) && empty($main_path)) {
            return $this->loadTranslations($path);
        }

        $keys   = $this->loadKeys($path);
        $source = $this->loadTranslations($main_path);

        return Arr::only($source, $keys);
    }

    public function store(string $path, array $content)
    {
        $this->log('Saving an array to a file:', $path);

        Arr::storeAsJson($path, $content, false, JSON_UNESCAPED_UNICODE ^ JSON_PRETTY_PRINT);
    }

    protected function loadKeys(string $path): array
    {
        $this->log('Loading keys from a file:', $path);

        return $this->loadFile($path);
    }

    protected function loadTranslations(string $path): array
    {
        $this->log('Loading translations from a file:', $path);

        $items = $this->loadFile($path);

        return Arrayable::of($items)
            ->renameKeys(static function ($key, $value) {
                return is_numeric($key) ? $value : $key;
            })->get();
    }

    protected function loadFile(string $path): array
    {
        $this->log('Loading data from a file:', $path);

        $content = Pretty::make()->loadRaw($path);

        $items = json_decode($content, true);

        return $this->correctValues($items);
    }
}
