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
     *
     * @return array<string, string[]>
     */
    public function all(array $plugins): array
    {
        $result = [];

        foreach ($plugins as $directory => $files) {
            foreach ($files as $file) {
                $result[$file->target] = array_merge(
                    $result[$file->target],
                    $this->load($directory, $file->source)
                );
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
