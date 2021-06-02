<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\PrettyArray\Services\File as Pretty;
use Helldar\Support\Facades\Helpers\Arr;

final class Json extends Filesystem
{
    public function load(string $path, string $filename): array
    {
        $this->log('Loading the contents of the file:', $path);

        if ($this->doesntExists($path)) {
            $this->log('File not found:', $path);

            return [];
        }

        dd($path, $filename);

        $keys   = $this->loadKeys($path);
        $source = $this->loadTranslations($filename);

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

    protected function loadTranslations(): array
    {
        dd(
            'aaaa',
            Path::sourceFull('laravel-lang/lang', 'en', 'en.json'),
        );
        // $this->log('Loading translations from a file:', $path);
    }

    protected function loadFile(string $path): array
    {
        $this->log('Loading data from a file:', $path);

        $content = Pretty::make()->loadRaw($path);

        $items = json_decode($content, true);

        return $this->correctValues($items);
    }
}
