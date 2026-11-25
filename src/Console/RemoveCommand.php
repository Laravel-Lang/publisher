<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use FilesystemIterator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Laravel\Prompts\Concerns\Colors;
use LaravelLang\Exceptions\InvalidLocalesArgumentException;
use LaravelLang\Exceptions\PathSearchException;
use LaravelLang\LocaleList\Locale;
use LaravelLang\Locales\Facades\Locales;
use UnexpectedValueException;

use function app;
use function basename;
use function clearstatcache;
use function dirname;
use function is_array;
use function is_link;
use function is_string;
use function lang_path;
use function Laravel\Prompts\confirm;
use function lstat;
use function realpath;
use function rmdir;
use function rtrim;
use function str_replace;
use function strcasecmp;

final class RemoveCommand extends Command
{
    use Colors;

    protected $signature = 'lang:rm {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Deleting localizations';

    public function __invoke(Filesystem $filesystem): int
    {
        if (! $locales = $this->locales()) {
            return self::SUCCESS;
        }

        return $this->perform($filesystem, $locales);
    }

    /** @param array<array-key, mixed> $locales */
    protected function perform(Filesystem $filesystem, array $locales): int
    {
        $protected = Locales::protects(false)->merge([
            app()->getLocale(),
            app()->getFallbackLocale(),
        ]);
        $result = self::SUCCESS;

        foreach ($locales as $locale) {
            if (! is_string($locale)) {
                throw InvalidLocalesArgumentException::expectedStrings();
            }

            $code = Locales::fromAlias($locale);

            if ($code === null || Locale::tryFrom($code) === null) {
                $this->components->twoColumnDetail($locale, $this->red('INVALID'));

                continue;
            }

            if ($protected->containsStrict($code)) {
                $this->components->twoColumnDetail($locale, $this->yellow('PROTECTED'));

                continue;
            }

            if (! Locales::isInstalled($locale)) {
                $this->components->twoColumnDetail($locale, $this->gray('SKIP'));

                continue;
            }

            $remaining = $this->remove($filesystem, $code);

            if ($remaining !== []) {
                $this->components->twoColumnDetail($locale, $this->red('FAILED'));

                foreach ($remaining as $path) {
                    $this->components->error("Unable to remove translation path [$path].");
                }

                $result = self::FAILURE;

                continue;
            }

            $this->components->twoColumnDetail($locale, $this->green('DONE'));
        }

        return $result;
    }

    /** @return list<string> */
    protected function remove(Filesystem $filesystem, string $code): array
    {
        $vendor = $filesystem->glob(lang_path('vendor/*'), GLOB_ONLYDIR);

        if ($vendor === false) {
            throw PathSearchException::forVendorTranslations();
        }

        $remaining = [];

        foreach ([lang_path(), ...$vendor] as $root) {
            $directory = "$root/$code";
            $json      = "$root/$code.json";

            $this->removeDirectoryEntry($filesystem, $directory, removeFile: false);
            $filesystem->delete($json);

            foreach ([$directory, $json] as $path) {
                clearstatcache(true, $path);

                if (@lstat($path) !== false) {
                    $remaining[] = $path;
                }
            }
        }

        return $remaining;
    }

    protected function removeDirectoryEntry(Filesystem $filesystem, string $path, bool $removeFile): void
    {
        if ($this->isDirectoryLink($path)) {
            if (! $filesystem->delete($path)) {
                // Windows removes directory symlinks and junctions with rmdir().
                @rmdir($path);
            }

            return;
        }

        if (! $filesystem->isDirectory($path)) {
            if ($removeFile) {
                $filesystem->delete($path);
            }

            return;
        }

        try {
            $entries = new FilesystemIterator($path);
        } catch (UnexpectedValueException) {
            return;
        }

        foreach ($entries as $entryPath => $_entry) {
            $this->removeDirectoryEntry($filesystem, $entryPath, removeFile: true);
        }

        unset($entries);
        @rmdir($path);
    }

    protected function isDirectoryLink(string $path): bool
    {
        if (is_link($path)) {
            return true;
        }

        // PHP can resolve an NTFS junction even when is_link() returns false.
        $parent = realpath(dirname($path));
        $target = realpath($path);

        if ($parent === false || $target === false) {
            return false;
        }

        $original = rtrim($parent, '/\\') . '/' . basename($path);

        return strcasecmp(str_replace('\\', '/', $target), str_replace('\\', '/', $original)) !== 0;
    }

    /** @return array<array-key, mixed> */
    protected function locales(): array
    {
        if ($locales = $this->argument('locales')) {
            if (! is_array($locales)) {
                throw InvalidLocalesArgumentException::expectedArray();
            }

            return $locales;
        }

        if (confirm('Do you want to remove all localizations?', default: false)) {
            return Locale::values();
        }

        return [];
    }
}
