<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests\Unit\Console\InlineOff\Remove;

use LaravelLang\LocaleList\Locale;
use LaravelLang\Locales\Facades\Locales;
use Tests\Unit\Console\InlineOff\TestCase;

class SuccessTest extends TestCase
{
    protected array $preinstall = [
        Locale::Afrikaans,
        Locale::Albanian,
        Locale::NorwegianBokmal,
    ];

    public function testDefault(): void
    {
        foreach ($this->preinstall as $locale) {
            $locale = $locale?->value ?? $locale;

            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach (Locales::protects() as $locale) {
            $locale = $locale->code;

            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        $this->artisanLangRemove($this->preinstall);

        foreach ($this->preinstall as $locale) {
            $locale = $locale?->value ?? $locale;

            $this->assertDirectoryDoesNotExist($this->config->langPath($locale));

            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach (Locales::protects() as $locale) {
            $locale = $locale->code;

            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }
    }
}
