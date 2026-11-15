<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Laravel\Prompts\Concerns\Colors;
use LaravelLang\LocaleList\Locale;

use LaravelLang\Locales\Facades\Locales;

use function lang_path;
use function Laravel\Prompts\confirm;

#[Signature('lang:rm {locales?* : Space-separated list of, eg: de tk it}')]
#[Description('Deleting localizations')]
final class RemoveCommand extends Command
{
    use Colors;

    public function __invoke(Filesystem $filesystem): int
    {
        if (! $locales = $this->locales()) {
            return self::SUCCESS;
        }

        $this->perform($filesystem, $locales);

        return self::SUCCESS;
    }

    protected function perform(Filesystem $filesystem, array $locales): void
    {
        foreach ($locales as $locale) {
            if (! $this->isValid($locale)) {
                $this->components->twoColumnDetail($locale, $this->red('INVALID'));

                continue;
            }

            if ($this->isProtected($locale)) {
                $this->components->twoColumnDetail($locale, $this->yellow('PROTECTED'));

                continue;
            }

            if (! $this->isInstalled($locale)) {
                $this->components->twoColumnDetail($locale, $this->gray('SKIP'));

                continue;
            }

            $this->remove($filesystem, $locale);

            $this->components->twoColumnDetail($locale, $this->green('DONE'));
        }
    }

    protected function remove(Filesystem $filesystem, string $locale): void
    {
        $this->deleteDirectories($filesystem, $locale);
        $this->deleteFiles($filesystem, $locale);
    }

    protected function deleteDirectories(Filesystem $filesystem, string $locale): void
    {
        $dirs = $filesystem->glob(lang_path("\{$locale,vendor/*/$locale}"), GLOB_ONLYDIR | GLOB_BRACE);

        foreach ($dirs as $dir) {
            $filesystem->deleteDirectory($dir);
        }
    }

    protected function deleteFiles(Filesystem $filesystem, string $locale): void
    {
        $files = $filesystem->glob(lang_path("\{$locale.json,vendor/*/$locale.json}"), GLOB_BRACE);

        $filesystem->delete($files);
    }

    protected function isValid(string $locale): bool
    {
        return Locales::isAvailable($locale);
    }

    protected function isProtected(string $locale): bool
    {
        return Locales::isProtected($locale);
    }

    protected function isInstalled(string $locale): bool
    {
        return Locales::isInstalled($locale);
    }

    protected function locales(): array
    {
        if ($locales = $this->argument('locales')) {
            return $locales;
        }

        if (confirm('Do you want to remove all localizations?', required: true)) {
            return Locale::values();
        }

        return [];
    }
}
