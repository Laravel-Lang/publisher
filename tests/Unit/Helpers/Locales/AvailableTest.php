<?php

namespace Tests\Unit\Helpers\Locales;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class AvailableTest extends TestCase
{
    public function testList(): void
    {
        $this->assertSame(Arr::sort(LocaleCode::values()), Locales::available());
    }
}
