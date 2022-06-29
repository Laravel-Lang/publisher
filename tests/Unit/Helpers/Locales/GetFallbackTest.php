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

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class GetFallbackTest extends TestCase
{
    protected LocaleCode $locale = LocaleCode::ENGLISH;

    protected LocaleCode $fallback_locale = LocaleCode::ENGLISH;

    public function testDefault(): void
    {
        $this->assertSame(LocaleCode::ENGLISH->value, Locales::getFallback());
    }

    public function testCustom(): void
    {
        config(['app.fallback_locale' => LocaleCode::GERMAN->value]);

        $this->assertSame(LocaleCode::GERMAN->value, Locales::getFallback());
    }

    public function testInvalid(): void
    {
        config(['app.fallback_locale' => 'foo']);

        $this->assertSame(LocaleCode::ENGLISH->value, Locales::getFallback());
    }

    public function testInvalidWhenDefaultWasChanged(): void
    {
        config(['app.locale' => LocaleCode::GERMAN->value]);
        config(['app.fallback_locale' => 'foo']);

        $this->assertSame(LocaleCode::GERMAN->value, Locales::getFallback());
    }

    public function testInvalidWhenDefaultInvalidToo(): void
    {
        config(['app.locale' => 'foo']);
        config(['app.fallback_locale' => 'foo']);

        $this->assertSame(LocaleCode::ENGLISH->value, Locales::getFallback());
    }
}
