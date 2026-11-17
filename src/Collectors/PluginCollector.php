<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Collectors;

use Illuminate\Support\Arr;
use LaravelLang\Filesystem\Composer;
use LaravelLang\Filesystem\Filesystem;
use LaravelLang\Publisher\Data\FileData;

use function array_map;
use function dirname;

class PluginCollector
{
    public function __construct(
        protected Filesystem $filesystem,
        protected Composer $composer,
    ) {}

    /**
     * @return array<string, FileData[]>
     */
    public function find(): array
    {
        $plugins = [];

        foreach ($this->settings() as $setting) {
            $directory = dirname($setting);

            $items = $this->filesystem->fromJson($setting, 'plugins');

            $filtered  = $this->filter($items);
            $collapsed = $this->collapse($filtered);

            $plugins[$directory] = $this->map($collapsed);
        }

        return $plugins;
    }

    protected function map(array $files): array
    {
        return array_map(
            static fn (array $file) => new FileData(
                source: $file['source'],
                target: $file['target'],
            ),
            $files
        );
    }

    protected function filter(array $plugins): array
    {
        $items = [];

        foreach ($plugins as $plugin) {
            $isProject = $plugin['project'] ?? false;
            $vendor    = $plugin['vendor'] ?? null;
            $version   = $plugin['version'] ?? null;
            $files     = $plugin['files'] ?? [];

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

    protected function collapse(array $items): array
    {
        return Arr::collapse($items);
    }

    protected function settings(): array
    {
        return $this->filesystem->glob(
            $this->filesystem->vendorPath('*/*/laravel_lang.json')
        );
    }
}
