<?php

namespace Tests\Commands;

use function compact;
use Helldar\LaravelLangPublisher\Exceptions\SourceLanguageNotExists;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

class InstallTest extends TestCase
{
    public function testWithoutLanguageAttribute()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "lang")');

        $this->artisan('lang:install');
    }

    public function testUnknownLanguage()
    {
        $this->expectException(SourceLanguageNotExists::class);
        $this->expectExceptionMessage('The source directory for "foo" localization was not found.');

        $lang = 'foo';

        $this->artisan('lang:install', compact('lang'));
    }

    public function testCanInstallWithoutForce()
    {
        $lang = ['de', 'ru', 'fr', 'zh-CN'];

        foreach ($lang as $value) {
            $this->assertDirectoryNotExists(
                resource_path('lang' . DIRECTORY_SEPARATOR . $value)
            );
        }

        $this->artisan('lang:install', compact('lang'))->assertExitCode(0);
        $this->assertSame('These credentials do not match our records.', Lang::get('auth.failed'));

        foreach ($lang as $value) {
            $this->assertDirectoryExists(
                resource_path('lang' . DIRECTORY_SEPARATOR . $value)
            );
        }
    }

    public function testCanInstallWithForce()
    {
        $parameters = [
            'lang'    => ['en'],
            '--force' => true,
        ];

        $this->copyFixtures();
        $this->artisan('lang:install', $parameters)->assertExitCode(0);
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
    }
}
