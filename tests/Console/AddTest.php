<?php

namespace Tests\Console;

use Helldar\LaravelLangPublisher\Exceptions\PackageDoesntExistsException;
use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleDoesntExistsException;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

final class AddTest extends TestCase
{
    public function testCancelConfirmation()
    {
        $this->artisan('lang:add')
            ->expectsConfirmation('Do you want to add all localizations?')
            ->expectsChoice('What languages to add? (specify the necessary localizations separated by commas)', 'ar', Locales::available())
            ->assertExitCode(0)
            ->run();
    }

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

        $nova_path  = $this->resources('lang/vendor/nova');
        $spark_path = $this->resources('lang/spark');

        $this->assertDirectoryDoesNotExist($nova_path);
        $this->assertDirectoryDoesNotExist($spark_path);

        foreach ($locales as $locale) {
            $path = $this->path($locale);

            $filename = $locale . '.json';

            $this->assertDirectoryDoesNotExist($path);

            $this->artisan('lang:add', ['locales' => $locale])->run();

            $this->assertDirectoryExists($path);
            $this->assertFileExists($nova_path . '/' . $filename);
        }

        $this->assertDirectoryExists($nova_path);
        $this->assertDirectoryExists($spark_path);
    }

    public function testCanInstallWithForce()
    {
        $this->copyFixtures();

        $this->artisan('lang:add', [
            'locales' => $this->default_locale,
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
            'locales' => $this->default_locale,
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
            'locales' => $this->default_locale,
            '--force' => true,
        ])->run();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('Confirm Password', Lang::get('Confirm Password'));
    }

    public function testIncorrectPackageName()
    {
        $this->expectException(PackageDoesntExistsException::class);
        $this->expectExceptionMessage('The "foo/bar" package is not a translation repository or does not exist.');

        $this->setPackages(['foo/bar']);

        $this->artisan('lang:add', ['locales' => $this->default_locale])->run();
    }

    public function testNotLocalized()
    {
        $this->expectException(PackageDoesntExistsException::class);
        $this->expectExceptionMessage('The "phpunit/phpunit" package is not a translation repository or does not exist.');

        $this->setPackages(['phpunit/phpunit']);

        $this->artisan('lang:add', ['locales' => $this->default_locale])->run();
    }
}
