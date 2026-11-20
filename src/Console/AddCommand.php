<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use LaravelLang\Exceptions\UnknownLocaleException;
use LaravelLang\LocaleList\Locale;

use LaravelLang\Locales\Facades\Locales;

use function lang_path;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\task;

#[Signature('lang:add {locales?* : Space-separated list of, eg: de tk it}')]
#[Description('Install new localizations')]
final class AddCommand extends Command
{
    public function __invoke(Filesystem $filesystem): int
    {
        if (! $locales = $this->locales()) {
            return self::SUCCESS;
        }

        $this->validate($locales);

        task('Adding localization', fn () => $this->create($filesystem, $locales));
        task('Updating localizations', fn () => $this->update());

        return self::SUCCESS;
    }

    protected function create(Filesystem $filesystem, array $locales): void
    {
        foreach ($locales as $locale) {
            $normalized = Locales::fromAlias($locale);

            $filesystem->ensureDirectoryExists(
                lang_path($normalized)
            );
        }
    }

    protected function update(): void
    {
        $this->callSilent(UpdateCommand::class);
    }

    protected function locales(): array
    {
        if ($locales = $this->argument('locales')) {
            return $locales;
        }

        if (confirm('Do you want to install all localizations?')) {
            return Locale::values();
        }

        return [];
    }

    protected function validate(array $locales): void
    {
        foreach ($locales as $locale) {
            if (! Locales::isAvailable($locale)) {
                throw new UnknownLocaleException($locale);
            }
        }
    }
}
