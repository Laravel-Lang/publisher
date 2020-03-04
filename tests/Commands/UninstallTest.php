<?php

namespace Tests\Commands;

use function compact;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

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
        $lang    = null;

        try {
            foreach ($locales as $locale) {
                $lang = $locale;
                $path = Path::target($locale);

                if (! File::exists($path)) {
                    File::makeDirectory($path);
                }
            }

            $this->artisan('lang:uninstall', compact('locales'))->assertExitCode(0);

            foreach ($locales as $locale) {
                $this->assertDirectoryNotExists(
                    Path::target($locale)
                );
            }
        } catch (\Exception $exception) {
            $path  = Path::target($lang);
            $perms = substr(sprintf('%o', fileperms($path)), -4);

            dd(compact('lang', 'perms', 'path'));
        }
    }
}
