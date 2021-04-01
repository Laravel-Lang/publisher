<?php

namespace Tests\Console\Json;

use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleFileDoesntExist;
use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\PublishJson;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

final class InstallTest extends TestCase
{
    protected $processor = PublishJson::class;

    protected $is_json = true;

    public function testWithoutLanguageAttribute()
    {
        $path = $this->path->target('ar');

        method_exists($this, 'assertFileDoesNotExist')
            ? $this->assertFileDoesNotExist($path)
            : $this->assertFileNotExists($path);

        $this->artisan('lang:install', ['--json' => true])
            ->expectsConfirmation('Do you want to install all localizations?')
            ->expectsChoice('What languages to install? (specify the necessary localizations separated by commas)', 'ar', Locale::available())
            ->assertExitCode(0);

        $this->assertFileExists($path);
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

        $this->localization()
            ->processor($this->getProcessor())
            ->run($locales);
    }

    public function testCanInstallWithoutForce()
    {
        $locales = ['de', 'ru', 'fr', 'zh_CN'];

        $this->deleteLocales($locales);

        foreach ($locales as $locale) {
            $path = $this->path->target($locale);

            method_exists($this, 'assertFileDoesNotExist')
                ? $this->assertFileDoesNotExist($path)
                : $this->assertFileNotExists($path);

            $this->localization()
                ->processor($this->getProcessor())
                ->run($locale);

            $this->assertFileExists($path);
        }
    }

    public function testCanInstallWithForce()
    {
        $this->copyFixtures();

        $this->localization()
            ->processor($this->getProcessor())
            ->force()
            ->run($this->default_locale);

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

        $this->localization()
            ->processor($this->getProcessor())
            ->force()
            ->run($this->default_locale);

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('Confirm Password', Lang::get('Confirm Password'));
    }
}
