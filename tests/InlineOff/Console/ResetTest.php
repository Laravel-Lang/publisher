<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Tests\InlineOff\Console;

use Illuminate\Support\Facades\Lang;
use Tests\InlineOffTestCase;

class ResetTest extends InlineOffTestCase
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
            ->expectsConfirmation('Do you want to reset all localizations?', 'yes')
            ->run();

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
            ->expectsConfirmation('Do you want to reset all localizations?', 'yes')
            ->run();

        Lang::setLoaded([]);

        $this->assertSame('These credentials do not match our records.', Lang::get('auth.failed'));
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));

        $this->assertSame('Foo', Lang::get('Foo'));
        $this->assertSame('Bar', Lang::get('Bar'));
        $this->assertSame('Baz', Lang::get('Baz'));
    }
}
