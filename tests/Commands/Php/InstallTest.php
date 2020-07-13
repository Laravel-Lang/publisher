<?php

namespace Tests\Commands\Php;

use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleDirectoryDoesntExist;
use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\PublishPhp;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

final class InstallTest extends TestCase
{
    protected $processor = PublishPhp::class;

    public function testWithoutLanguageAttribute()
    {
        $path = $this->path->target('ar');

        method_exists($this, 'assertDirectoryDoesNotExist')
            ? $this->assertDirectoryDoesNotExist($path)
            : $this->assertDirectoryNotExists($path);

        $this->artisan('lang:install')
            ->expectsConfirmation('Do you want to install all localizations?', 'no')
            ->expectsChoice('What languages to install? (specify the necessary localizations separated by commas)', 'ar', Locale::available())
            ->assertExitCode(0);

        $this->assertDirectoryExists($path);
    }

    public function testUnknownLanguageFromCommand()
    {
        $this->expectException(SourceLocaleDirectoryDoesntExist::class);
        $this->expectExceptionMessage('The source directory for "foo" localization was not found.');

        $locales = 'foo';

        $this->artisan('lang:install', compact('locales'));
    }

    public function testUnknownLanguageFromService()
    {
        $this->expectException(SourceLocaleDirectoryDoesntExist::class);
        $this->expectExceptionMessage('The source directory for "foo" localization was not found.');

        $locales = 'foo';

        $this->localization()
            ->setPath($this->getPath())
            ->setProcessor($this->getProcessor())
            ->run($locales);
    }

    public function testCanInstallWithoutForce()
    {
        $locales = ['de', 'ru', 'fr', 'zh-CN'];

        $this->deleteLocales($locales);

        foreach ($locales as $locale) {
            $path = $this->path->target($locale);

            method_exists($this, 'assertDirectoryDoesNotExist')
                ? $this->assertDirectoryDoesNotExist($path)
                : $this->assertDirectoryNotExists($path);

            $this->localization()
                ->setPath($this->getPath())
                ->setProcessor($this->getProcessor())
                ->run($locale);

            $this->assertDirectoryExists($path);
        }
    }

    public function testCanInstallWithForce()
    {
        $this->copyFixtures();
        $this->localization()
            ->setPath($this->getPath())
            ->setProcessor($this->getProcessor())
            ->run($this->default_locale, true);

        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
    }
}
