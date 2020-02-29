<?php

namespace Tests\Commands;

use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function testUpdate()
    {
        $this->copyFixtures();

        $this->artisan('lang:update')->assertExitCode(0);

        $this->assertSame('These credentials do not match our records.', Lang::get('auth.failed'));
    }

    public function testExcludeKeys()
    {
        $this->copyConfig();
        $this->copyFixtures();

        $this->artisan('lang:update')->assertExitCode(0);

        $this->assertSame('These credentials do not match our records.', Lang::get('auth.failed'));
        $this->assertSame('Foo', Lang::get('auth.throttle'));
    }
}
