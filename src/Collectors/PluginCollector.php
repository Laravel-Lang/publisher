<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Collectors;

use LaravelLang\Filesystem\Composer;
use LaravelLang\Filesystem\Filesystem;

use LaravelLang\Publisher\Data\FileData;

use function array_map;

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
            $directory = $setting['directory'];

            $items = $this->filesystem->fromJson($setting, 'plugins');

            if ($filtered = $this->filter($items)) {
                $plugins[$directory] = $this->map($filtered);
            }
        }

        return $plugins;
    }

    protected function map(array $plugins): array
    {
        return array_map(static fn (array $file) => new FileData(
            source: $file['source'],
            target: $file['target'],
        ), $plugins);
    }

    protected function filter(array $plugins): array
    {
        $result = [];

        foreach ($plugins as $directory => $items) {
            foreach ($items as $plugin) {
                $isProject = $plugin['project'] ?? false;
                $vendor    = $plugin['vendor'] ?? null;
                $version   = $plugin['version'] ?? null;
                $files     = $plugin['files'] ?? [];

                if ($isProject) {
                    if ($this->composer->hasProject($vendor)) {
                        $result[$directory][] = $files;
                    }

                    continue;
                }

                if (! $this->composer->hasPackage($vendor)) {
                    continue;
                }

                if (! $this->composer->hasVersion($vendor, $version)) {
                    continue;
                }

                $result[$directory][] = $files;
            }
        }

        return $result;
    }

    protected function settings(): array
    {
        return $this->filesystem->glob(
            $this->filesystem->vendorPath('*/*/laravel_lang.json')
        );
    }
}
