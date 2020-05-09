<?php

namespace Tests\Commands\Main;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

class UninstallTest extends TestCase
{
    public function testWithoutLanguageAttributeFromCommand()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "locales")');

        $this->artisan('lang:uninstall');
    }

    public function testUninstall()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $path = $this->pathTarget($locale);

            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $this->localization()->delete($locale);

            $this->assertDirectoryNotExists($path);
        }
    }

    public function testUninstallDefaultLocale()
    {
        $locale = Locale::getDefault();
        $path   = $this->pathTarget($locale);

        $this->localization()->delete($locale);

        $this->assertDirectoryExists($path);
    }
}
