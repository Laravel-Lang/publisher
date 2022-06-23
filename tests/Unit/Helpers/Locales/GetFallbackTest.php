<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class GetFallbackTest extends TestCase
{
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
