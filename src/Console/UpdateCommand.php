<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaravelLang\Exceptions\InvalidTranslationKeyException;
use LaravelLang\Exceptions\InvalidTranslationSkipPatternException;
use LaravelLang\Filesystem\Filesystem;
use LaravelLang\Locales\Facades\Locales;
use LaravelLang\Publisher\Collectors\PluginCollector;
use LaravelLang\Publisher\Collectors\SourceCollector;
use LaravelLang\Publisher\Contracts\Decorator;
use LaravelLang\Publisher\Loaders\TranslationLoader;
use Stringable;

use function array_replace;
use function basename;
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
        Decorator $decorator,
    ): int {
        $plugins = task('Find plugins', $pluginCollector->find(...));
        $source  = task('Collecting source', fn (): array => $sourceCollector->all($plugins));

        task('Updating locales', fn () => $this->updateLocales($filesystem, $translationLoader, $decorator, $source));

        return self::SUCCESS;
    }

    /** @param  array<string, list<TranslationSource>>  $source */
    protected function updateLocales(
        Filesystem $filesystem,
        TranslationLoader $loader,
        Decorator $decorator,
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

                    $filled = $this->fill($decorator, $locale, $library, $package, $data['items']);

                    if (basename($filename) === 'validation.php') {
                        $filled = array_replace(
                            $this->withoutDefaultValidationMessage($filesystem->fromPhp($path)),
                            $this->withoutDefaultValidationMessage($filled),
                        );
                        $trailingKeys = $filename === '{locale}/validation.php' ? ['custom', 'attributes'] : [];

                        $filesystem->storePhpArrayWithTrailingKeys($path, $filled, $trailingKeys);
                    } else {
                        $filesystem->storeArray($path, $filled, true);
                    }
                }
            }
        }
    }

    /**
     * @param  array<array-key, mixed>  $items
     * @return array<array-key, mixed>
     */
    protected function withoutDefaultValidationMessage(array $items): array
    {
        $items = Arr::dot($items);
        $key   = 'custom.attribute-name.rule-name';

        if (($items[$key] ?? null) === 'custom-message') {
            unset($items[$key]);
        }

        return $items;
    }

    /**
     * @param  array<array-key, mixed>  $library
     * @param  array<array-key, mixed>  $package
     * @param  array<array-key, mixed>  $items
     * @return array<array-key, mixed>
     */
    protected function fill(Decorator $decorator, string $locale, array $library, array $package, array $items): array
    {
        return $this->translate($decorator, $locale, array_replace($library, $package), $items);
    }

    /**
     * @param  array<array-key, mixed>  $library
     * @param  array<array-key, mixed>  $items
     * @return array<array-key, mixed>
     */
    protected function translate(Decorator $decorator, string $locale, array $library, array $items): array
    {
        foreach ($items as &$value) {
            if (is_array($value)) {
                $value = $this->translate($decorator, $locale, $library, $value);

                continue;
            }

            $key = match (true) {
                is_int($value), is_string($value) => $value,
                is_bool($value), is_float($value) => (int) $value,
                $value === null                   => '',
                default                           => throw new InvalidTranslationKeyException,
            };

            $value = $library[$key] ?? $value;

            if (is_string($value)) {
                $value = $decorator->convert($locale, $value);
            }
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
