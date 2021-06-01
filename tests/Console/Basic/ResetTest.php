<?php

namespace Tests\Console\Basic;

use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

final class ResetTest extends TestCase
{
    public function testWithoutFullOption()
    {
        $this->copyFixtures();

        $this->assertSame('Foo', Lang::get('auth.failed'));
        $this->assertSame('Foo', Lang::get('auth.throttle'));

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('Baz'));

        $this->artisan('lang:reset')
            ->expectsConfirmation('Do you want to reset all localizations?', 'yes');

        Lang::setLoaded([]);

        $this->assertSame('Foo', Lang::get('auth.failed'));
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));

        $this->assertSame('Foo', Lang::get('Foo'));
        $this->assertSame('Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('Baz'));
    }

    public function testWithFullOption()
    {
        $this->copyFixtures();

        $this->assertSame('Foo', Lang::get('auth.failed'));
        $this->assertSame('Foo', Lang::get('auth.throttle'));

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('Baz'));

        $this->artisan('lang:reset', ['--full' => true])
            ->expectsConfirmation('Do you want to reset all localizations?', 'yes');

        Lang::setLoaded([]);

        $this->assertSame('These credentials do not match our records.', Lang::get('auth.failed'));
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));

        $this->assertSame('Foo', Lang::get('Foo'));
        $this->assertSame('Bar', Lang::get('Bar'));
        $this->assertSame('Baz', Lang::get('Baz'));
    }
}
