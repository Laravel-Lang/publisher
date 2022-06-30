<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2022 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

namespace Tests\Unit\Helpers\Locales;

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
}
