<?php

namespace Tests\Commands\Json;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

class UninstallTest extends TestCase
{
    protected $is_json = true;

    public function testWithoutLanguageAttributeFromCommand()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "locales")');

        $this->artisan('lang:uninstall', ['--json' => true]);
    }

    public function testUninstall()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $path = Path::target($locale);

            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $this->localization()->delete($locale, true);

            method_exists($this, 'assertFileDoesNotExist')
                ? $this->assertFileDoesNotExist($path)
                : $this->assertFileNotExists($path);
        }
    }

    public function testUninstallDefaultLocale()
    {
        $locale = Locale::getDefault();
        $path   = Path::target($locale);

        $this->localization()->delete($locale, true);

        $this->assertFileExists($path);
    }
}
