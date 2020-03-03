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

        $this->assertSame('Foo', Lang::get('auth.failed'));
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
    }

    public function testExcludeKeys()
    {
        $this->copyFixtures();

        $this->artisan('lang:update')->assertExitCode(0);

        $this->assertSame('Foo', Lang::get('auth.failed'));
    }
}
