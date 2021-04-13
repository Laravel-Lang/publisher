<?php

namespace Tests\Console;

use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleDoesntExistsException;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

final class InstallTest extends TestCase
{
    public function testCancelConfirmation()
    {
        $this->artisan('lang:install')
            ->expectsConfirmation('Do you want to install all localizations?')
            ->expectsChoice('What languages to install? (specify the necessary localizations separated by commas)', 'ar', Locales::available())
            ->assertExitCode(0)
            ->run();
    }

    public function testAcceptConfirmation()
    {
        $this->artisan('lang:install')
            ->expectsConfirmation('Do you want to install all localizations?')
            ->expectsChoice('What languages to install? (specify the necessary localizations separated by commas)', 'ar', Locales::available())
            ->assertExitCode(0)
            ->run();
    }

    public function testUnknownLanguageFromCommand()
    {
        $this->expectException(SourceLocaleDoesntExistsException::class);
        $this->expectExceptionMessage('The source "foo" localization was not found.');

        $locales = 'foo';

        $this->artisan('lang:install', compact('locales'));
    }

    public function testCanInstallWithoutForce()
    {
        $locales = ['de', 'ru', 'fr', 'zh_CN'];

        foreach ($locales as $locale) {
            $php_path  = $this->path($locale, null, true);
            $json_path = $this->path($locale);

            $this->assertDirectoryDoesNotExist($php_path);
            $this->assertFileDoesNotExist($json_path);

            $this->artisan('lang:install', ['locales' => $locale])->run();

            $this->assertDirectoryExists($php_path);
            $this->assertFileExists($json_path);
        }
    }

    public function testCanInstallWithForce()
    {
        $this->copyFixtures();

        $this->artisan('lang:install', [
            'locales' => $this->default_locale,
            '--force' => true,
        ])->run();

        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
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

        $this->artisan('lang:install', [
            'locales' => $this->default_locale,
            '--force' => true,
        ])->run();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('Confirm Password', Lang::get('Confirm Password'));
    }
}
