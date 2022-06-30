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

class IsProtectedTest extends TestCase
{
    protected LocaleCode $fallback_locale = LocaleCode::ENGLISH;

    public function testDefault(): void
    {
        $this->assertTrue(Locales::isProtected(LocaleCode::ENGLISH));

        $this->assertFalse(Locales::isProtected(LocaleCode::GERMAN));
        $this->assertFalse(Locales::isProtected(LocaleCode::FRENCH));
    }

    public function testCustomDefault(): void
    {
        config(['app.locale' => LocaleCode::GERMAN->value]);

        $this->assertTrue(Locales::isProtected(LocaleCode::ENGLISH));
        $this->assertTrue(Locales::isProtected(LocaleCode::GERMAN));

        $this->assertFalse(Locales::isProtected(LocaleCode::FRENCH));
    }

    public function testCustomFallback(): void
    {
        config(['app.fallback_locale' => LocaleCode::GERMAN->value]);

        $this->assertTrue(Locales::isProtected(LocaleCode::ENGLISH));
        $this->assertTrue(Locales::isProtected(LocaleCode::GERMAN));

        $this->assertFalse(Locales::isProtected(LocaleCode::FRENCH));
    }

    public function testInvalid(): void
    {
        $this->assertFalse(Locales::isProtected('foo'));
    }
}
