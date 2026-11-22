<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use LaravelLang\Exceptions\InvalidTranslationKeyException;
use LaravelLang\Exceptions\InvalidTranslationSkipPatternException;
use LaravelLang\Filesystem\Filesystem;
use LaravelLang\Locales\Facades\Locales;
use LaravelLang\Publisher\Collectors\PluginCollector;
use LaravelLang\Publisher\Collectors\SourceCollector;
use LaravelLang\Publisher\Loaders\TranslationLoader;
use Stringable;

use function array_merge;
use function config;
use function is_array;
use function lang_path;
use function Laravel\Prompts\task;
use function str_replace;

/** @phpstan-import-type TranslationSource from SourceCollector */
final class UpdateCommand extends Command
{
    protected $signature = 'lang:update';

    protected $description = 'Updating installed localizations';

    public function __invoke(
        Filesystem $filesystem,
        PluginCollector $pluginCollector,
        SourceCollector $sourceCollector,
        TranslationLoader $translationLoader,
    ): int {
        $plugins = task('Find plugins', $pluginCollector->find(...));
        $source  = task('Collecting source', fn (): array => $sourceCollector->all($plugins));

        task('Updating locales', fn () => $this->updateLocales($filesystem, $translationLoader, $source));

        return self::SUCCESS;
    }

    /** @param array<string, list<TranslationSource>> $source */
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

    /**
     * @param  array<array-key, mixed>  $library
     * @param  array<array-key, mixed>  $package
     * @param  array<array-key, mixed>  $items
     * @return array<array-key, mixed>
     */
    protected function fill(array $library, array $package, array $items): array
    {
        return $this->translate(array_merge($library, $package), $items);
    }

    /**
     * @param  array<array-key, mixed>  $library
     * @param  array<array-key, mixed>  $items
     * @return array<array-key, mixed>
     */
    protected function translate(array $library, array $items): array
    {
        foreach ($items as &$value) {
            if (is_array($value)) {
                $value = $this->translate($library, $value);

                continue;
            }

            $key = match (true) {
                is_int($value), is_string($value) => $value,
                is_bool($value), is_float($value) => (int) $value,
                $value === null                   => '',
                default                           => throw new InvalidTranslationKeyException,
            };

            $value = $library[$key] ?? $value;
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

        foreach (config()->array('localization_main.skip') as $pattern) {
            if (! is_scalar($pattern) && ! $pattern instanceof Stringable && $pattern !== null) {
                throw new InvalidTranslationSkipPatternException;
            }

            if (Str::is((string) $pattern, $prepared, true)) {
                return true;
            }
        }

        return false;
    }
}
