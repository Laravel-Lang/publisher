<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use Illuminate\Filesystem\Filesystem;
use LaravelLang\LocaleList\Locale;

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

        task('Adding localization', fn () => $this->create($filesystem, $locales));
        task('Updating localizations', fn () => $this->update());

        return self::SUCCESS;
    }

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

    protected function locales(): array
    {
        if ($locales = $this->argument('locales')) {
            return $locales;
        }

        if (confirm('Do you want to install all localizations?', required: true)) {
            return Locale::values();
        }

        return [];
    }
}
