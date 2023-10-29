<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Locales\Enums\Config;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class IsInstalledTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertTrue(Locales::isInstalled(LocaleCode::ENGLISH));
        $this->assertTrue(Locales::isInstalled(LocaleCode::FRENCH));

        $this->assertFalse(Locales::isInstalled(LocaleCode::AFRIKAANS));
        $this->assertFalse(Locales::isInstalled(LocaleCode::GERMAN));
    }

    public function testCustom(): void
    {
        $this->artisanLangAdd([
            LocaleCode::GERMAN,
            LocaleCode::FRENCH,
        ]);

        $this->assertTrue(Locales::isInstalled(LocaleCode::ENGLISH));
        $this->assertTrue(Locales::isInstalled(LocaleCode::GERMAN));
        $this->assertTrue(Locales::isInstalled(LocaleCode::FRENCH));
    }

    public function testAlias(): void
    {
        $this->app['config']->set(Config::PublicKey() . '.aliases', [
            LocaleCode::GERMAN->value => 'de-DE',
        ]);

        $this->artisanLangAdd([
            LocaleCode::GERMAN,
        ]);

        $this->assertTrue(Locales::isInstalled('de'));
        $this->assertTrue(Locales::isInstalled('de-DE'));
    }
}
