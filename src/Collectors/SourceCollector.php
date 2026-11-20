<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Collectors;

use Illuminate\Support\Arr;
use LaravelLang\Filesystem\Filesystem;
use LaravelLang\Publisher\Data\FileData;

use function array_merge;

class SourceCollector
{
    public function __construct(
        protected Filesystem $filesystem,
    ) {}

    /**
     * @param  array<string, FileData[]>  $plugins
     * @return array<string, array<array<string, array>>>
     */
    public function all(array $plugins): array
    {
        $result = [];

        foreach ($plugins as $directory => $files) {
            $items = [];

            foreach ($files as $file) {
                $data = $this->load($directory, $file->source);

                if ($data === []) {
                    continue;
                }

                $result[$file->target][] = [
                    'directory' => $directory,
                    'items'     => array_merge($items, $data),
                ];
            }
        }

        return $result;
    }

    protected function load(string $directory, string $filename): array
    {
        $path = $directory . '/source/' . $filename;

        if ($this->filesystem->isJson($path)) {
            return $this->filesystem->fromJson($path);
        }

        return Arr::dot(
            $this->filesystem->fromPhp($path)
        );
    }
}
