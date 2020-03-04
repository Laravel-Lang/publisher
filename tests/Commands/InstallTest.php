<?php

namespace Tests\Commands;

use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleNotExists;
use Helldar\LaravelLangPublisher\Facades\Locale;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

use function compact;

class InstallTest extends TestCase
{
    public function testWithoutLanguageAttribute()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "locales")');

        $this->artisan('lang:install');
    }

    public function testUnknownLanguage()
    {
        $this->expectException(SourceLocaleNotExists::class);
        $this->expectExceptionMessage('The source directory for "foo" localization was not found.');

        $locales = 'foo';

        $this->artisan('lang:install', compact('locales'));
    }

    public function testCanInstallWithoutForce()
    {
        $locales = ['de', 'ru', 'fr', 'zh-CN'];

        $this->deleteLocales($locales);

        foreach ($locales as $locale) {
            $this->assertDirectoryNotExists(
                resource_path('lang' . DIRECTORY_SEPARATOR . $locale)
            );
        }

        $this->artisan('lang:install', compact('locales'))->assertExitCode(0);

        foreach ($locales as $locale) {
            $this->assertDirectoryExists(
                resource_path('lang' . DIRECTORY_SEPARATOR . $locale)
            );
        }
    }

    public function testCanInstallWithForce()
    {
        $parameters = [
            'locales' => $this->default_locale,
            '--force' => true,
        ];

        $this->copyFixtures();
        $this->artisan('lang:install', $parameters)->assertExitCode(0);
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
    }

    public function testInstallAllWithoutForce()
    {
        $locales = ['*'];

        $this->artisan('lang:install', compact('locales'))->assertExitCode(0);
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));

        foreach (Locale::available() as $locale) {
            $this->assertDirectoryExists(
                resource_path('lang' . DIRECTORY_SEPARATOR . $locale)
            );
        }
    }
}
