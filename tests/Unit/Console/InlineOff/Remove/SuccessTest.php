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

class SuccessTest extends TestCase
{
    protected array $preinstall = [
        LocaleCode::AFRIKAANS,
        LocaleCode::ALBANIAN,
        LocaleCode::NORWEGIAN_BOKMAL,
    ];

    public function testDefault(): void
    {
        foreach ($this->preinstall as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach (Locales::protects() as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }

        $this->artisanLangRemove($this->preinstall);

        foreach ($this->preinstall as $locale) {
            $this->assertDirectoryDoesNotExist($this->config->langPath($locale));

            $this->assertFileDoesNotExist($this->config->langPath($locale . '.json'));
            $this->assertFileDoesNotExist($this->config->langPath($locale, 'validation.php'));
            $this->assertFileDoesNotExist($this->config->langPath("vendor/baq/$locale.json"));
        }

        foreach (Locales::protects() as $locale) {
            $this->assertFileExists($this->config->langPath($locale . '.json'));
            $this->assertFileExists($this->config->langPath($locale, 'validation.php'));
            $this->assertFileExists($this->config->langPath("vendor/baq/$locale.json"));
        }
    }
}
