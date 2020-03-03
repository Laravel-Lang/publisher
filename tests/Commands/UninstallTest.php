<?php

namespace Tests\Commands;

use function compact;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

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
        $lang = ['de', 'ru', 'fr', 'zh-CN'];

        $this->artisan('lang:install', compact('lang'))->assertExitCode(0);

        foreach ($lang as $value) {
            $this->assertDirectoryExists(
                resource_path('lang' . DIRECTORY_SEPARATOR . $value)
            );
        }

        $this->artisan('lang:uninstall', compact('lang'))->assertExitCode(0);

        foreach ($lang as $value) {
            $this->assertDirectoryNotExists(
                resource_path('lang' . DIRECTORY_SEPARATOR . $value)
            );
        }
    }
}
