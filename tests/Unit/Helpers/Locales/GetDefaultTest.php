<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class GetDefaultTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertSame(LocaleCode::ENGLISH->value, Locales::getDefault());
    }

    public function testCustom(): void
    {
        config(['app.locale' => LocaleCode::GERMAN->value]);

        $this->assertSame(LocaleCode::GERMAN->value, Locales::getDefault());
    }

    public function testInvalid(): void
    {
        config(['app.locale' => 'foo']);

        $this->assertSame(LocaleCode::ENGLISH->value, Locales::getDefault());
    }
}
