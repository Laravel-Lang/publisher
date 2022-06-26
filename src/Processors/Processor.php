<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Processors;

use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Console\OutputStyle;
use LaravelLang\Publisher\Concerns\Has;
use LaravelLang\Publisher\Concerns\Path;
use LaravelLang\Publisher\Helpers\Config;
use LaravelLang\Publisher\Plugins\Plugin;
use LaravelLang\Publisher\Services\Filesystem\Manager;

abstract class Processor
{
    use Has;
    use Path;

    public function __construct(
        readonly protected OutputStyle $output,
        readonly protected array       $locales,
        readonly protected bool        $reset,
        readonly protected Config      $config = new Config(),
        readonly protected Manager     $filesystem = new Manager()
    ) {
    }

    public function collect(): self
    {
        $this->output->info('Collecting localizations...');

        foreach ($this->plugins() as $directory => $plugins) {
            /** @var Plugin $plugin */
            foreach ($plugins as $plugin) {
                $this->output->info("\t" . get_class($plugin) . '...');

                $this->collectKeys($directory, array_keys($plugin->files()));
                $this->collectLocalizations($directory, array_values($plugin->files()));
            }
        }

        return $this;
    }

    public function store(): void
    {
        $this->output->info('Storing changes...');
    }

    protected function collectKeys(string $directory, array $files): void
    {
        foreach ($files as $file) {
            $values = $this->filesystem->load($directory . '/' . $file);
            // TODO: set source keys
        }
    }

    protected function collectLocalizations(string $directory, array $files): void
    {
        foreach ($files as $file) {
            foreach ($this->locales as $locale) {
                $path = $this->localeFilename($locale, $directory . '/' . $file);

                $values = $this->filesystem->load($path);
                // TODO: set localization keys
            }
        }
    }

    /**
     * @return array<\LaravelLang\Publisher\Plugins\Plugin>
     */
    protected function plugins(): array
    {
        return Arr::of($this->config->plugins())
            ->map(static function (array $plugins): array {
                return Arr::of($plugins)
                    ->map(static fn (string $plugin) => new $plugin)
                    ->filter(static fn (Plugin $plugin) => $plugin->has())
                    ->toArray();
            })
            ->filter()
            ->toArray();
    }
}
