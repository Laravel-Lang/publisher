<?php

namespace Tests\Commands;

use function compact;
use Helldar\LaravelLangPublisher\Facades\Path;
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

        $lang = null;

        try {
            $this->artisan('lang:install', compact('locales'))->assertExitCode(0);

            foreach ($locales as $locale) {
                $this->assertDirectoryExists(
                    Path::target($locale)
                );
            }

            $this->artisan('lang:uninstall', compact('locales'))->assertExitCode(0);

            foreach ($locales as $locale) {
                $this->assertDirectoryNotExists(
                    Path::target($locale)
                );
            }
        } catch (\Exception $exception) {
            $lang = 'be';
            $path = Path::target($lang);

            dd([
                'message'     => $exception->getMessage(),
                'dir'         => $path,
                'is_dir'      => is_dir($path),
                'is_file'     => is_file($path),
                'is_link'     => is_link($path),
                'is_readable' => is_readable($path),
                'is_writable' => is_writable($path),
                'chmod'       => substr(sprintf('%o', fileperms($path)), -4),
            ]);
        }
    }
}
