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
use Illuminate\Support\Facades\Lang;
use Tests\InlineOffTestCase;

class AddTest extends InlineOffTestCase
{
    public function testAcceptConfirmation()
    {
        $this->artisan('lang:add')
            ->expectsConfirmation('Do you want to add all localizations?')
            ->expectsChoice('What languages to add? (specify the necessary localizations separated by commas)', 'ar', Locales::available())
            ->assertExitCode(0)
            ->run();
    }

    public function testUnknownLanguageFromCommand()
    {
        $this->expectException(SourceLocaleDoesntExistsException::class);
        $this->expectExceptionMessage('The source "foo" localization was not found.');

        $locales = 'foo';

        $this->artisan('lang:add', compact('locales'));
    }

    public function testCanInstallWithoutForce()
    {
        $locales = ['de', 'ru', 'fr', 'zh_CN'];

        $nova_path  = $this->resourcesPath('vendor/nova');
        $spark_path = $this->resourcesPath('spark');

        $this->assertDirectoryDoesNotExist($nova_path);
        $this->assertDirectoryDoesNotExist($spark_path);

        foreach ($locales as $locale) {
            $path = $this->resourcesPath($locale);

            $this->assertDirectoryDoesNotExist($path);

            $this->artisan('lang:add', ['locales' => $locale])->run();

            $this->assertDirectoryExists($path);
            $this->assertFileExists($nova_path . '/' . $locale . '.json');
        }

        $this->assertDirectoryExists($nova_path);
        $this->assertDirectoryExists($spark_path);
    }

    public function testCanInstallWithForce()
    {
        $this->copyFixtures();

        $this->artisan('lang:add', [
            'locales' => $this->default,
            '--force' => true,
        ])->run();

        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('Remember Me', Lang::get('Remember Me'));
    }

    public function testSkipped()
    {
        $this->copyFixtures();

        $this->artisan('lang:add', [
            'locales' => $this->default,
        ])->run();

        $this->assertSame('Foo', Lang::get('auth.throttle'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('Remember Me', Lang::get('Remember Me'));
    }

    public function testExcludes()
    {
        $this->copyFixtures();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('This is Baq', Lang::get('Confirm Password'));

        Lang::setLoaded([]);

        $this->artisan('lang:add', [
            'locales' => $this->default,
            '--force' => true,
        ])->run();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('Confirm Password', Lang::get('Confirm Password'));
    }

    public function testCheckInstalledKeys()
    {
        $this->emulatePaidPackages(true);

        $locales = Locales::available();

        $this->artisan('lang:add', [
            'locales' => $locales,
            '--force' => true,
        ])->run();

        foreach ($this->packages() as $package) {
            foreach ($locales as $locale) {
                $this->assertTrue(Locales::isInstalled($locale), 'Locale is not installed: ' . $locale);

                $this->filesTest($package, $locale);
                $this->pluginsTest($package, $locale);
            }
        }
    }
}
