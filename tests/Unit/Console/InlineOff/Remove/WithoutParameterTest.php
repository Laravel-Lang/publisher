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

use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\Unit\Console\InlineOff\TestCase;

class WithoutParameterTest extends TestCase
{
    public function testNo(): void
    {
        $available = Locales::available();
        $installed = Locales::installed();
        $protected = Locales::protects();

        foreach ($installed as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/$locale.json"));
        }

        foreach ($protected as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/$locale.json"));
        }

        foreach (array_diff($available, $installed) as $locale) {
            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/$locale.json"));
        }

        $this->artisan('lang:rm')
            ->expectsConfirmation('Do you want to remove all localizations?')
            ->run();

        foreach ($installed as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/$locale.json"));
        }

        foreach ($protected as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/$locale.json"));
        }

        foreach (array_diff($available, $installed) as $locale) {
            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/$locale.json"));
        }
    }

    public function testYes(): void
    {
        $available = Locales::available();
        $installed = Locales::installed();
        $protected = Locales::protects();

        foreach ($installed as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/$locale.json"));
        }

        foreach ($protected as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/$locale.json"));
        }

        foreach (array_diff($available, $installed) as $locale) {
            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/$locale.json"));
        }

        $this->artisan('lang:add')
            ->expectsConfirmation('Do you want to remove all localizations?', 'yes')
            ->run();

        foreach ($protected as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/$locale.json"));
        }

        foreach (array_diff($available, $protected) as $locale) {
            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/$locale.json"));
        }
    }
}
