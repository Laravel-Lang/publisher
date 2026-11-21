<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Collectors;

use Illuminate\Container\Attributes\Config;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaravelLang\Filesystem\Composer;
use LaravelLang\Filesystem\Filesystem;
use LaravelLang\Publisher\Data\FileData;

use function array_filter;
use function array_map;
use function dirname;

/**
 * @phpstan-type PluginFile array{source: string, target: string}
 * @phpstan-type PluginDefinition array{project?: bool, vendor?: string|null, version?: string|null, files?: array<PluginFile>|null}
 */
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
            static fn (array $file): FileData => new FileData(
                source: $file['source'],
                target: $file['target'],
            ),
            $files
        );
    }

    /**
     * @param  array<PluginDefinition>  $plugins
     * @return list<array<PluginFile>>
     */
    protected function filter(array $plugins): array
    {
        $items = [];

        foreach ($plugins as $plugin) {
            $isProject = $plugin['project'] ?? false;
            $vendor    = $plugin['vendor']  ?? null;
            $version   = $plugin['version'] ?? null;
            $files     = $plugin['files']   ?? [];

            if ($isProject) {
                if ($this->composer->hasProject($vendor)) {
                    $items[] = $files;
                }

                continue;
            }

            if (! $this->composer->hasPackage($vendor)) {
                continue;
            }

            if (! $this->composer->hasVersion($vendor, $version)) {
                continue;
            }

            $items[] = $files;
        }

        return $items;
    }

    /**
     * @param  array<PluginFile>  $files
     * @return array<PluginFile>
     */
    protected function skip(string $directory, array $files): array
    {
        return array_filter($files, function (array $file) use ($directory): bool {
            ['source' => $source] = $file;

            return ! $this->needSkip($directory . '/source/' . $source);
        });
    }

    /**
     * @param  list<array<PluginFile>>  $items
     * @return array<PluginFile>
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
