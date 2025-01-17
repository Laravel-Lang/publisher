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

namespace Tests\Unit\Console\InlineOn\Add;

use LaravelLang\LocaleList\Locale;
use LaravelLang\Locales\Facades\Locales;
use Tests\Unit\Console\InlineOn\TestCase;

class WithoutParameterTest extends TestCase
{
    public function testNo(): void
    {
        $installed = [Locale::English, Locale::French];
        $notInstalled = [Locale::NorwegianBokmal, Locale::Afrikaans];

        foreach ($installed as $locale) {
            $locale = $locale?->value ?? $locale;

            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach ($notInstalled as $locale) {
            $locale = $locale?->value ?? $locale;

            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/baq/$locale.json"));
        }

        $this->artisan('lang:add')
            ->expectsConfirmation('Do you want to install all localizations?')
            ->run();

        foreach ($installed as $locale) {
            $locale = $locale?->value ?? $locale;

            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach ($notInstalled as $locale) {
            $locale = $locale?->value ?? $locale;

            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/baq/$locale.json"));
        }
    }

    public function testYes(): void
    {
        $installed = [Locale::English, Locale::French];
        $notInstalled = [Locale::NorwegianBokmal, Locale::Afrikaans];

        foreach ($installed as $locale) {
            $locale = $locale?->value ?? $locale;

            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach ($notInstalled as $locale) {
            $locale = $locale?->value ?? $locale;

            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/baq/$locale.json"));
        }

        $this->artisan('lang:add')
            ->expectsConfirmation('Do you want to install all localizations?', 'yes')
            ->run();

        foreach (Locales::available() as $locale) {
            $locale = $locale->code;

            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }
    }
}
