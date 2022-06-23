<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class IsAvailableTest extends TestCase
{
    public function testEach(): void
    {
        foreach (LocaleCode::values() as $locale) {
            $this->assertTrue(Locales::isAvailable($locale));
        }
    }

    public function testIncorrect(): void
    {
        $this->assertFalse(Locales::isAvailable('FOO'));
        $this->assertFalse(Locales::isAvailable('BAR'));

        $this->assertFalse(Locales::isAvailable('AA'));
        $this->assertFalse(Locales::isAvailable('BB'));

        $this->assertFalse(Locales::isAvailable('cc'));
        $this->assertFalse(Locales::isAvailable('dd'));
    }
}
