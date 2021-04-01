<?php

namespace Tests\Console\Php;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\DeletePhp;
use Illuminate\Support\Str;
use Tests\TestCase;

class UninstallTest extends TestCase
{
    protected $processor = DeletePhp::class;

    public function testWithoutLanguageAttribute()
    {
        $path = Str::finish(
            $this->path->target('ar'),
            DIRECTORY_SEPARATOR
        );

        $this->artisan('lang:install', ['locales' => 'ar']);

        $this->assertFileExists($path . 'auth.php');
        $this->assertFileExists($path . 'pagination.php');
        $this->assertFileExists($path . 'passwords.php');
        $this->assertFileExists($path . 'validation.php');

//        $this->artisan('lang:uninstall')
//            ->expectsConfirmation('Do you want to uninstall all localizations?')
//            ->expectsChoice('What languages to uninstall? (specify the necessary localizations separated by commas)', 'ar', ['ar', 'en'])
//            ->assertExitCode(0);
//
//        if (method_exists($this, 'assertFileDoesNotExist')) {
//            $this->assertFileDoesNotExist($path . 'auth.php');
//            $this->assertFileDoesNotExist($path . 'pagination.php');
//            $this->assertFileDoesNotExist($path . 'passwords.php');
//            $this->assertFileDoesNotExist($path . 'validation.php');
//        } else {
//            $this->assertFileNotExists($path . 'auth.php');
//            $this->assertFileNotExists($path . 'pagination.php');
//            $this->assertFileNotExists($path . 'passwords.php');
//            $this->assertFileNotExists($path . 'validation.php');
//        }
    }

    public function testUninstall()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $path = Str::finish(
                $this->path->target('ar'),
                DIRECTORY_SEPARATOR
            );

            $this->localization()
                ->processor($this->getProcessor())
                ->force()
                ->run($locale);

            if (method_exists($this, 'assertFileDoesNotExist')) {
                $this->assertFileDoesNotExist($path . 'auth.php');
                $this->assertFileDoesNotExist($path . 'pagination.php');
                $this->assertFileDoesNotExist($path . 'passwords.php');
                $this->assertFileDoesNotExist($path . 'validation.php');
            } else {
                $this->assertFileNotExists($path . 'auth.php');
                $this->assertFileNotExists($path . 'pagination.php');
                $this->assertFileNotExists($path . 'passwords.php');
                $this->assertFileNotExists($path . 'validation.php');
            }
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

        $this->assertDirectoryExists($path);
    }
}
