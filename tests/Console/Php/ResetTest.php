<?php

namespace Tests\Console\Php;

use Helldar\LaravelLangPublisher\Services\Processors\ResetPhp;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

final class ResetTest extends TestCase
{
    protected $processor = ResetPhp::class;

    public function testWithoutFullOption()
    {
        $this->copyFixtures();

        $this->assertSame('Foo', Lang::get('auth.failed'));
        $this->assertSame('Foo', Lang::get('auth.throttle'));

        $this->artisan('lang:reset')
            ->expectsConfirmation('Do you want to reset all localizations?', 'yes');

        Lang::setLoaded([]);

        $this->assertSame('Foo', Lang::get('auth.failed'));
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
    }

    public function testWithFullOption()
    {
        $this->copyFixtures();

        $this->assertSame('Foo', Lang::get('auth.failed'));
        $this->assertSame('Foo', Lang::get('auth.throttle'));

        $this->artisan('lang:reset', ['--full' => true])
            ->expectsConfirmation('Do you want to reset all localizations?', 'yes');

        Lang::setLoaded([]);

        $this->assertSame('These credentials do not match our records.', Lang::get('auth.failed'));
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
    }
}
