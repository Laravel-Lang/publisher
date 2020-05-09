<?php

namespace Tests\Commands\Json;

use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleNotExists;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

final class InstallTest extends TestCase
{
    public function testWithoutLanguageAttribute()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "locales")');

        $this->artisan('lang:install', ['--json' => true]);
    }

    public function testUnknownLanguageFromCommand()
    {
        $this->expectException(SourceLocaleNotExists::class);
        $this->expectExceptionMessage('The source directory for "foo" localization was not found.');

        $this->artisan('lang:install', [
            'locales' => 'foo',
            '--json'  => true,
        ]);
    }

    public function testUnknownLanguageFromService()
    {
        $this->expectException(SourceLocaleNotExists::class);
        $this->expectExceptionMessage('The source directory for "foo" localization was not found.');

        $locales = 'foo';

        $this->localization()->publish($locales, false, true);
    }

    public function testCanInstallWithoutForce()
    {
        $locales = ['de', 'ru', 'fr', 'zh-CN'];

        $this->deleteLocales($locales);

        foreach ($locales as $locale) {
            $path = $this->pathTarget($locale);

            $this->assertDirectoryNotExists($path);

            $this->localization()->publish($locale, false, true);

            $this->assertDirectoryExists($path);
        }
    }

    public function testCanInstallWithForce()
    {
        $this->copyFixtures();
        $this->localization()->publish($this->default_locale, true, true);

        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
    }
}
