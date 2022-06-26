<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\Unit\Console\InlineOff\Remove;

use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\Unit\Console\InlineOff\TestCase;

class WithoutParameterTest extends TestCase
{
    protected LocaleCode $fallback_locale = LocaleCode::FRENCH;

    public function testNo(): void
    {
        $installed     = [LocaleCode::ENGLISH, LocaleCode::FRENCH];
        $not_installed = [LocaleCode::NORWEGIAN_BOKMAL, LocaleCode::AFRIKAANS];

        foreach ($installed as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach ($not_installed as $locale) {
            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/baq/$locale.json"));
        }

        $this->artisan('lang:rm')
            ->expectsConfirmation('Do you want to remove all localizations?')
            ->run();

        foreach ($installed as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach ($not_installed as $locale) {
            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/baq/$locale.json"));
        }
    }

    public function testYes(): void
    {
        $installed     = [LocaleCode::ENGLISH, LocaleCode::FRENCH];
        $not_installed = [LocaleCode::NORWEGIAN_BOKMAL, LocaleCode::AFRIKAANS];

        foreach ($installed as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach ($not_installed as $locale) {
            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/baq/$locale.json"));
        }

        $this->artisan('lang:rm')
            ->expectsConfirmation('Do you want to remove all localizations?', 'yes')
            ->run();

        foreach (Locales::protects() as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach (Locales::notInstalled() as $locale) {
            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/baq/$locale.json"));
        }
    }
}
