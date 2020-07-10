<?php

namespace Tests\Commands;

use function compact;
use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleNotExists;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Console\Exception\RuntimeException;

use Tests\TestCase;

class InstallTest extends TestCase
{
    public function testWithoutLanguageAttribute()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "locales")');

        $this->artisan('lang:install');
    }

    public function testUnknownLanguageFromCommand()
    {
        $this->expectException(SourceLocaleNotExists::class);
        $this->expectExceptionMessage('The source directory for "foo" localization was not found.');

        $locales = 'foo';

        $this->artisan('lang:install', compact('locales'));
    }

    public function testUnknownLanguageFromService()
    {
        $this->expectException(SourceLocaleNotExists::class);
        $this->expectExceptionMessage('The source directory for "foo" localization was not found.');

        $locales = 'foo';

        $this->localization()->publish($locales);
    }

    public function testCanInstallWithoutForce()
    {
        $locales = ['de', 'ru', 'fr', 'zh-CN'];

        $this->deleteLocales($locales);

        foreach ($locales as $locale) {
            $path = Path::target($locale);

            method_exists($this, 'assertDirectoryDoesNotExist')
                ? $this->assertDirectoryDoesNotExist($path)
                : $this->assertDirectoryNotExists($path);

            $this->localization()->publish($locale);

            $this->assertDirectoryExists($path);
        }
    }

    public function testCanInstallWithForce()
    {
        $this->copyFixtures();
        $this->localization()->publish($this->default_locale, true);

        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
    }
}
