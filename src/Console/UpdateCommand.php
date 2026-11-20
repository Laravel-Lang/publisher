<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use LaravelLang\Filesystem\Filesystem;
use LaravelLang\Locales\Facades\Locales;
use LaravelLang\Publisher\Collectors\PluginCollector;
use LaravelLang\Publisher\Collectors\SourceCollector;
use LaravelLang\Publisher\Loaders\TranslationLoader;

use function array_merge;
use function config;
use function is_array;
use function lang_path;
use function Laravel\Prompts\task;
use function str_replace;

#[Description('Updating installed localizations')]
#[Signature('lang:update')]
final class UpdateCommand extends Command
{
    public function __invoke(
        Filesystem $filesystem,
        PluginCollector $pluginCollector,
        SourceCollector $sourceCollector,
        TranslationLoader $translationLoader,
    ): int {
        task('Find plugins', function () use ($pluginCollector, &$plugins): void {
            $plugins = $pluginCollector->find();
        });

        task('Collecting source', function () use ($sourceCollector, $plugins, &$source): void {
            $source = $sourceCollector->all($plugins);
        });

        task('Updating locales', function () use ($filesystem, $translationLoader, $source): void {
            $this->updateLocales($filesystem, $translationLoader, $source);
        });

        return self::SUCCESS;
    }

    protected function updateLocales(
        Filesystem $filesystem,
        TranslationLoader $loader,
        array $source,
    ): void {
        foreach (Locales::installed(false) as $locale) {
            $library = $loader->get($filesystem->libraryPath(), $locale);

            foreach ($source as $filename => $translatable) {
                foreach ($translatable as $data) {
                    $path = $this->targetPath($filename, $locale);

                    if ($this->needSkip($path)) {
                        continue;
                    }

                    $package = $loader->get($data['directory'], $locale);

                    $filled = $this->fill($library, $package, $data['items']);

                    $filesystem->storeArray($path, $filled, true);
                }
            }
        }
    }

    protected function fill(array $library, array $package, array $items): array
    {
        return $this->translate(array_merge($library, $package), $items);
    }

    protected function translate(array $library, array $items): array
    {
        foreach ($items as &$value) {
            if (is_array($value)) {
                $value = $this->translate($library, $value);

                continue;
            }

            $value = $library[$value] ?? $value;
        }

        return $items;
    }

    protected function targetPath(string $filename, string $locale): string
    {
        return lang_path(str_replace('{locale}', $locale, $filename));
    }

    protected function needSkip(string $path): bool
    {
        $prepared = str_replace('\\', '/', $path);

        return Str::is(config()->array('localization_main.skip'), $prepared, true);
    }
}
