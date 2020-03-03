<?php

namespace Tests\Commands;

use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

use function compact;
use function file_exists;
use function resource_path;

class UninstallTest extends TestCase
{
    public function testWithoutLanguageAttribute()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "lang")');

        $this->artisan('lang:uninstall');
    }

    public function testUninstall()
    {
        $lang = ['be', 'da', 'gl', 'is'];

        foreach ($lang as $value) {
            $path = resource_path('lang' . DIRECTORY_SEPARATOR . $value);

            if (! file_exists($path)) {
                File::makeDirectory($path);
            }
        }

        $this->artisan('lang:uninstall', compact('lang'))->assertExitCode(0);

        foreach ($lang as $value) {
            $this->assertDirectoryNotExists(
                resource_path('lang' . DIRECTORY_SEPARATOR . $value)
            );
        }
    }
}
