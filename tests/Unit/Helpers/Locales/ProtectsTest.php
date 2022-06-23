<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class ProtectsTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertSame(['en'], Locales::protects());
    }

    public function testCustomDefault(): void
    {
        config(['app.locale' => 'de']);

        $this->assertSame(['de', 'en'], Locales::protects());
    }

    public function testCustomFallback(): void
    {
        config(['app.fallback_locale' => 'de']);

        $this->assertSame(['de', 'en'], Locales::protects());
    }

    public function testCustomAll(): void
    {
        config(['app.locale' => 'de']);
        config(['app.fallback_locale' => 'fr']);

        $this->assertSame(['de', 'fr'], Locales::protects());
    }
}
