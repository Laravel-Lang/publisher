<?php

namespace Tests\Commands;

use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

use function compact;
use function resource_path;

class UninstallTest extends TestCase
{
    public function testWithoutLanguageAttribute()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "locales")');

        $this->artisan('lang:uninstall');
    }

    public function testUninstall()
    {
        $locales = ['be', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $path = resource_path('lang' . DIRECTORY_SEPARATOR . $locale);

            if (! File::exists($path)) {
                File::makeDirectory($path);
            }
        }

        $this->artisan('lang:uninstall', compact('locales'))->assertExitCode(0);

        foreach ($locales as $locale) {
            $this->assertDirectoryNotExists(
                resource_path('lang' . DIRECTORY_SEPARATOR . $locale)
            );
        }
    }
}
