<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use LaravelLang\Exceptions\UnknownLocaleException;
use LaravelLang\LocaleList\Locale;
use LaravelLang\Locales\Facades\Locales;
use Symfony\Component\Console\Exception\InvalidArgumentException;

use function is_array;
use function is_string;
use function lang_path;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\task;

final class AddCommand extends Command
{
    protected $signature = 'lang:add {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Install new localizations';

    public function __invoke(Filesystem $filesystem): int
    {
        if (! $locales = $this->locales()) {
            return self::SUCCESS;
        }

        $locales = $this->normalize($locales);

        task('Adding localization', fn () => $this->create($filesystem, $locales));
        task('Updating localizations', fn () => $this->update());

        return self::SUCCESS;
    }

    /** @param array<string> $locales */
    protected function create(Filesystem $filesystem, array $locales): void
    {
        foreach ($locales as $locale) {
            $filesystem->ensureDirectoryExists(
                lang_path($locale)
            );
        }
    }

    protected function update(): void
    {
        $this->callSilent(UpdateCommand::class);
    }

    /** @return array<array-key, mixed> */
    protected function locales(): array
    {
        if ($locales = $this->argument('locales')) {
            if (! is_array($locales)) {
                throw new InvalidArgumentException('The locales argument must be an array.');
            }

            return $locales;
        }

        if (confirm('Do you want to install all localizations?')) {
            return Locale::values();
        }

        return [];
    }

    /**
     * @param  array<array-key, mixed>  $locales
     * @return list<string>
     */
    protected function normalize(array $locales): array
    {
        $normalized = [];

        foreach ($locales as $locale) {
            if (! is_string($locale)) {
                throw new InvalidArgumentException('Each locale must be a string.');
            }

            $code = Locales::fromAlias($locale);

            if ($code === null || Locale::tryFrom($code) === null) {
                throw new UnknownLocaleException($locale);
            }

            $normalized[] = $code;
        }

        return $normalized;
    }
}
