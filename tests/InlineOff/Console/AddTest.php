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

use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleDoesntExistsException;
use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Tests\InlineOffTestCase;

class AddTest extends InlineOffTestCase
{
    public function testAcceptConfirmation()
    {
        $this->artisan('lang:add')
            ->expectsConfirmation('Do you want to add all localizations?')
            ->expectsChoice('Select localizations to add (specify the necessary localizations separated by commas):', 'ar', Locales::available())
            ->assertExitCode(0)
            ->run();
    }

    public function testUnknownLanguageFromCommand()
    {
        $this->expectException(SourceLocaleDoesntExistsException::class);
        $this->expectExceptionMessage('The source "foo" localization was not found.');

        $locales = 'foo';

        $this->artisan('lang:add', compact('locales'))->run();
    }

    public function testExcludes()
    {
        $this->copyFixtures();

        $this->assertSame('Foo', __('auth.throttle'));
        $this->assertSame('Foo.', __('validation.accepted'));

        $this->assertSame('This is Foo', __('Foo'));
        $this->assertSame('This is Bar', __('Bar'));
        $this->assertSame('This is Baz', __('All rights reserved.'));
        $this->assertSame('This is Baq', __('Confirm Password'));

        $this->refreshTranslations();

        $this->artisan('lang:add', [
            'locales' => $this->default,
        ])->run();

        $this->assertSame('Foo', __('auth.throttle'));
        $this->assertSame('Foo.', __('validation.accepted'));

        $this->assertSame('This is Foo', __('Foo'));
        $this->assertSame('This is Bar', __('Bar'));
        $this->assertSame('This is Baz', __('All rights reserved.'));
        $this->assertSame('Confirm Password', __('Confirm Password'));
    }

    public function testWithForce()
    {
        $this->copyFixtures();

        $this->assertSame('Foo', __('auth.throttle'));
        $this->assertSame('Foo.', __('validation.accepted'));

        $this->assertSame('This is Foo', __('Foo'));
        $this->assertSame('This is Bar', __('Bar'));
        $this->assertSame('This is Baz', __('All rights reserved.'));
        $this->assertSame('This is Baq', __('Confirm Password'));

        $this->refreshTranslations();

        $this->artisan('lang:add', [
            'locales' => $this->default,
            '--force' => true,
        ])->run();

        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', __('auth.throttle'));
        $this->assertSame('The :attribute must be accepted.', __('validation.accepted'));

        $this->assertSame('This is Foo', __('Foo'));
        $this->assertSame('This is Bar', __('Bar'));

        $this->assertSame('All rights reserved.', __('All rights reserved.'));
        $this->assertSame('Confirm Password', __('Confirm Password'));
    }
}
