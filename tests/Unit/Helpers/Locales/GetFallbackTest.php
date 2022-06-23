<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class GetFallbackTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertSame('en', Locales::getFallback());
    }

    public function testCustom(): void
    {
        config(['app.fallback_locale' => 'de']);

        $this->assertSame('de', Locales::getFallback());
    }

    public function testInvalid(): void
    {
        config(['app.fallback_locale' => 'foo']);

        $this->assertSame('en', Locales::getFallback());
    }

    public function testInvalidWhenDefaultWasChanged(): void
    {
        config(['app.locale' => 'de']);
        config(['app.fallback_locale' => 'foo']);

        $this->assertSame('de', Locales::getFallback());
    }

    public function testInvalidWhenDefaultInvalidToo(): void
    {
        config(['app.locale' => 'foo']);
        config(['app.fallback_locale' => 'foo']);

        $this->assertSame('en', Locales::getFallback());
    }
}
