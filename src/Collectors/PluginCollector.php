<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Collectors;

use Illuminate\Container\Attributes\Config;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaravelLang\Filesystem\Composer;
use LaravelLang\Filesystem\Filesystem;
use LaravelLang\Publisher\Data\FileData;
use TypeError;

use function array_map;
use function dirname;

/** @phpstan-type PluginFile array{source: string, ...<array-key, mixed>} */
class PluginCollector
{
    /** @param array<string> $skip */
    public function __construct(
        #[Config('localization_main.skip')]
        protected array $skip,
        protected Filesystem $filesystem,
        protected Composer $composer,
    ) {}

    /** @return array<string, FileData[]> */
    public function find(): array
    {
        $plugins = [];

        foreach ($this->settings() as $setting) {
            $directory = dirname($setting);

            $items = $this->filesystem->fromJson($setting, 'plugins');

            $items = $this->filter($items);
            $items = $this->collapse($items);
            $items = $this->skip($directory, $items);

            $plugins[$directory] = $this->map($items);
        }

        return $plugins;
    }

    /**
     * @param  array<PluginFile>  $files
     * @return array<FileData>
     */
    protected function map(array $files): array
    {
        return array_map(
            static function (array $file): FileData {
                $target = $file['target'] ?? null;

                if (! is_string($target)) {
                    throw new TypeError('A translation plugin file must have a string target path.');
                }

                return new FileData(source: $file['source'], target: $target);
            },
            $files
        );
    }

    /**
     * @param  array<array-key, mixed>  $plugins
     * @return list<array<array-key, mixed>>
     */
    protected function filter(array $plugins): array
    {
        $items = [];

        foreach ($plugins as $plugin) {
            if (! is_array($plugin)) {
                continue;
            }

            $isProject = $plugin['project'] ?? false;
            $vendor    = $plugin['vendor']  ?? null;
            $files     = $plugin['files']   ?? null;

            if ($vendor !== null && ! is_string($vendor)) {
                throw new TypeError('The translation plugin vendor must be a string or null.');
            }

            if ($isProject) {
                if ($this->composer->hasProject($vendor)) {
                    $items[] = is_array($files) ? $files : [];
                }

                continue;
            }

            if (! $this->composer->hasPackage($vendor)) {
                continue;
            }

            $version = $plugin['version'] ?? null;

            if ($version !== null && ! is_string($version)) {
                throw new TypeError('The translation plugin version must be a string or null.');
            }

            if (! $this->composer->hasVersion($vendor, $version)) {
                continue;
            }

            $items[] = is_array($files) ? $files : [];
        }

        return $items;
    }

    /**
     * @param  array<array-key, mixed>  $files
     * @return array<PluginFile>
     */
    protected function skip(string $directory, array $files): array
    {
        $included = [];

        foreach ($files as $key => $file) {
            if (! is_array($file) || ! is_string($file['source'] ?? null)) {
                throw new TypeError('A translation plugin file must have a string source path.');
            }

            if (! $this->needSkip($directory . '/source/' . $file['source'])) {
                $included[$key] = $file;
            }
        }

        return $included;
    }

    /**
     * @param  list<array<array-key, mixed>>  $items
     * @return array<array-key, mixed>
     */
    protected function collapse(array $items): array
    {
        return Arr::collapse($items);
    }

    /** @return array<string> */
    protected function settings(): array
    {
        return $this->filesystem->glob(
            $this->filesystem->vendorPath('*/*/laravel_lang.json')
        );
    }

    protected function needSkip(string $path): bool
    {
        $prepared = str_replace('\\', '/', $path);

        return Str::is($this->skip, $prepared, true);
    }
}
