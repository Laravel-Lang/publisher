<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class InstalledTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertSame([
            LocaleCode::ENGLISH->value,
        ], Locales::installed());
    }

    public function testCustom(): void
    {
        $this->preinstall = [
            LocaleCode::GERMAN,
            LocaleCode::FRENCH,
        ];

        $this->assertSame([
            LocaleCode::GERMAN->value,
            LocaleCode::ENGLISH->value,
            LocaleCode::FRENCH->value,
        ], Locales::installed());
    }

    public function testProtected(): void
    {
        $this->preinstall = [LocaleCode::GERMAN];

        config(['app.fallback_locale' => LocaleCode::FRENCH->value]);

        $this->assertSame([
            LocaleCode::GERMAN->value,
            LocaleCode::ENGLISH->value,
            LocaleCode::FRENCH->value,
        ], Locales::installed());
    }
}
