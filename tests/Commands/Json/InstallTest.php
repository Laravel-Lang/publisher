<?php

namespace Tests\Commands\Json;

use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleFileDoesntExist;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

final class InstallTest extends TestCase
{
    protected $is_json = true;

    public function testWithoutLanguageAttribute()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "locales")');

        $this->artisan('lang:install', ['--json' => true]);
    }

    public function testUnknownLanguageFromCommand()
    {
        $this->expectException(SourceLocaleFileDoesntExist::class);
        $this->expectExceptionMessage('The source "foo" localization was not found.');

        $this->artisan('lang:install', [
            'locales' => 'foo',
            '--json'  => true,
        ]);
    }

    public function testUnknownLanguageFromService()
    {
        $this->expectException(SourceLocaleFileDoesntExist::class);
        $this->expectExceptionMessage('The source "foo" localization was not found.');

        $locales = 'foo';

        $this->localization()->publish($locales, false, true);
    }

    public function testCanInstallWithoutForce()
    {
        $locales = ['de', 'ru', 'fr', 'zh-CN'];

        $this->deleteLocales($locales);

        foreach ($locales as $locale) {
            $path = Path::target($locale);

            method_exists($this, 'assertFileDoesNotExist')
                ? $this->assertFileDoesNotExist($path)
                : $this->assertFileNotExists($path);

            $this->localization()->publish($locale, false, true);

            $this->assertFileExists($path);
        }
    }

    public function testCanInstallWithForce()
    {
        $this->copyFixtures();

        $this->localization()->publish($this->default_locale, true, true);

        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('Remember Me', __('Remember Me'));
    }

    public function testExcludes()
    {
        $this->copyFixtures();

        $this->localization()->publish($this->default_locale, true, true);

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('Confirm Password', Lang::get('Confirm Password'));
    }
}
