<?php

namespace Tests\Commands\Php;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\DeletePhp;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class UninstallTest extends TestCase
{
    protected $processor = DeletePhp::class;

    public function testWithoutLanguageAttribute()
    {
        $path = $this->path->target('ar');

        $this->artisan('lang:install', ['locales' => 'ar']);

        $this->assertDirectoryExists($path);

        $this->artisan('lang:uninstall')
            ->expectsConfirmation('Do you want to uninstall all localizations?', 'no')
            ->expectsChoice('What languages to uninstall? (specify the necessary localizations separated by commas)', 'ar', ['ar', 'en'])
            ->assertExitCode(0);

        method_exists($this, 'assertDirectoryDoesNotExist')
            ? $this->assertDirectoryDoesNotExist($path)
            : $this->assertDirectoryNotExists($path);
    }

    public function testUninstall()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $path = $this->path->target($locale);

            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $this->localization()
                ->setPath($this->getPath())
                ->setProcessor($this->getProcessor())
                ->run($locale, true);

            method_exists($this, 'assertDirectoryDoesNotExist')
                ? $this->assertDirectoryDoesNotExist($path)
                : $this->assertDirectoryNotExists($path);
        }
    }

    public function testUninstallDefaultLocale()
    {
        $locale = Locale::getDefault();
        $path   = $this->path->target($locale);

        $this->localization()
            ->setPath($this->getPath())
            ->setProcessor($this->getProcessor())
            ->run($locale, true);

        $this->assertDirectoryExists($path);
    }
}
