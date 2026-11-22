<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Laravel\Prompts\Concerns\Colors;
use LaravelLang\Exceptions\InvalidLocalesArgumentException;
use LaravelLang\Exceptions\PathSearchException;
use LaravelLang\LocaleList\Locale;
use LaravelLang\Locales\Facades\Locales;

use function app;
use function is_array;
use function is_string;
use function lang_path;
use function Laravel\Prompts\confirm;

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

        $this->perform($filesystem, $locales);

        return self::SUCCESS;
    }

    /** @param array<array-key, mixed> $locales */
    protected function perform(Filesystem $filesystem, array $locales): void
    {
        $protected = Locales::protects(false)->merge([
            app()->getLocale(),
            app()->getFallbackLocale(),
        ]);

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

            $this->remove($filesystem, $code);

            $this->components->twoColumnDetail($locale, $this->green('DONE'));
        }
    }

    protected function remove(Filesystem $filesystem, string $code): void
    {
        $vendor = $filesystem->glob(lang_path('vendor/*'), GLOB_ONLYDIR);

        if ($vendor === false) {
            throw PathSearchException::forVendorTranslations();
        }

        foreach ([lang_path(), ...$vendor] as $root) {
            $filesystem->deleteDirectory("$root/$code");
            $filesystem->delete("$root/$code.json");
        }
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
