<?php

namespace Tests\Console\Json;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\DeleteJson;
use Tests\TestCase;

class UninstallTest extends TestCase
{
    protected $processor = DeleteJson::class;

    protected $is_json = true;

    public function testWithoutLanguageAttribute()
    {
        $path = $this->path->target('ar');

        $this->artisan('lang:install', ['locales' => 'ar', '--json' => true]);

        $this->assertFileExists($path);

        $this->artisan('lang:uninstall', ['--json' => true])
            ->expectsConfirmation('Do you want to uninstall all localizations?', 'no')
            ->expectsChoice('What languages to uninstall? (specify the necessary localizations separated by commas)', 'ar', ['ar', 'en'])
            ->assertExitCode(0);

        method_exists($this, 'assertFileDoesNotExist')
            ? $this->assertFileDoesNotExist($path)
            : $this->assertFileNotExists($path);
    }

    public function testUninstall()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $path = $this->path->target($locale);

            $this->localization()
                ->processor($this->getProcessor())
                ->force()
                ->run($locale);

            method_exists($this, 'assertFileDoesNotExist')
                ? $this->assertFileDoesNotExist($path)
                : $this->assertFileNotExists($path);
        }
    }

    public function testUninstallDefaultLocale()
    {
        $locale = Locale::getDefault();
        $path   = $this->path->target($locale);

        $this->localization()
            ->processor($this->getProcessor())
            ->force()
            ->run($locale);

        $this->assertFileExists($path);
    }
}
