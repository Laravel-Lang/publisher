<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class IsInstalledTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertTrue(Locales::isInstalled(LocaleCode::ENGLISH));

        $this->assertFalse(Locales::isInstalled(LocaleCode::GERMAN));
        $this->assertFalse(Locales::isInstalled(LocaleCode::FRENCH));
    }

    public function testCustom(): void
    {
        $this->preinstall = [
            LocaleCode::GERMAN,
            LocaleCode::FRENCH,
        ];

        $this->assertTrue(Locales::isInstalled(LocaleCode::ENGLISH));
        $this->assertTrue(Locales::isInstalled(LocaleCode::GERMAN));
        $this->assertTrue(Locales::isInstalled(LocaleCode::FRENCH));
    }
}
