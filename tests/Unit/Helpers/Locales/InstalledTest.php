<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class InstalledTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertSame(['en'], Locales::installed());
    }

    public function testCustom(): void
    {
        $this->preinstall = ['de', 'fr'];

        $this->assertSame(['de', 'en', 'fr'], Locales::installed());
    }

    public function testProtected(): void
    {
        $this->preinstall = ['de'];

        config(['app.fallback_locale' => 'fr']);

        $this->assertSame(['de', 'en', 'fr'], Locales::installed());
    }
}
