<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class IsInstalledTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertTrue(Locales::isInstalled('en'));

        $this->assertFalse(Locales::isInstalled('de'));
        $this->assertFalse(Locales::isInstalled('fr'));
    }

    public function testCustom(): void
    {
        $this->preinstall = ['de', 'fr'];

        $this->assertTrue(Locales::isInstalled('en'));
        $this->assertTrue(Locales::isInstalled('de'));
        $this->assertTrue(Locales::isInstalled('fr'));
    }
}
