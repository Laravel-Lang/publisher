<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class IsProtectedTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertTrue(Locales::isProtected('en'));

        $this->assertFalse(Locales::isProtected('de'));
        $this->assertFalse(Locales::isProtected('fr'));
    }

    public function testCustomDefault(): void
    {
        config(['app.locale' => 'de']);

        $this->assertTrue(Locales::isProtected('en'));
        $this->assertTrue(Locales::isProtected('de'));

        $this->assertFalse(Locales::isProtected('fr'));
    }

    public function testCustomFallback(): void
    {
        config(['app.fallback_locale' => 'de']);

        $this->assertTrue(Locales::isProtected('en'));
        $this->assertTrue(Locales::isProtected('de'));

        $this->assertFalse(Locales::isProtected('fr'));
    }

    public function testInvalid(): void
    {
        $this->assertFalse(Locales::isProtected('foo'));
    }
}
