<?php

namespace Tests\Commands;

use Helldar\LaravelLangPublisher\Facades\Path;
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
        $locales = ['be', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $path = Path::target($locale);

            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $this->localization()->delete($locale);

            $this->assertDirectoryNotExists($path);
        }
    }
}
