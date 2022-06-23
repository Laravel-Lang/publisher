<?php

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class GetDefaultTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertSame('en', Locales::getDefault());
    }

    public function testCustom(): void
    {
        config(['app.locale' => 'de']);

        $this->assertSame('de', Locales::getDefault());
    }

    public function testInvalid(): void
    {
        config(['app.locale' => 'foo']);

        $this->assertSame('en', Locales::getDefault());
    }
}
