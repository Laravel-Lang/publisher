<?php

namespace Tests\Console\Basic;

use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

final class UpdateTest extends TestCase
{
    public function testExcludes()
    {
        $this->copyFixtures();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('This is Baq', Lang::get('Confirm Password'));

        Lang::setLoaded([]);

        $this->artisan('lang:update')->run();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('Confirm Password', Lang::get('Confirm Password'));
    }
}
