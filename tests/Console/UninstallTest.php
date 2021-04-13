<?php

namespace Tests\Console;

use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Facades\Path;
use Tests\TestCase;

final class UninstallTest extends TestCase
{
    public function testWithoutLanguageAttribute()
    {
        $locale = 'ar';

        $this->artisan('lang:install', ['locales' => $locale])->run();

        $this->assertFileExists($this->path($locale));
        $this->assertFileExists($this->path($locale, 'auth.php'));
        $this->assertFileExists($this->path($locale, 'pagination.php'));
        $this->assertFileExists($this->path($locale, 'passwords.php'));
        $this->assertFileExists($this->path($locale, 'validation.php'));
        $this->assertDirectoryExists($this->path($locale, null, true));

        $this->artisan('lang:uninstall')
            ->expectsConfirmation('Do you want to uninstall all localizations?')
            ->expectsChoice('What languages to uninstall? (specify the necessary localizations separated by commas)', 'ar', Locales::installed())
            ->assertExitCode(0);

        $this->assertFileDoesNotExist($this->path($locale));
        $this->assertFileDoesNotExist($this->path($locale, 'auth.php'));
        $this->assertFileDoesNotExist($this->path($locale, 'pagination.php'));
        $this->assertFileDoesNotExist($this->path($locale, 'passwords.php'));
        $this->assertFileDoesNotExist($this->path($locale, 'validation.php'));
        $this->assertDirectoryDoesNotExist($this->path($locale, null, true));
    }

    public function testUninstall()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        $this->artisan('lang:install', ['locales' => $locales, '--force' => true])->run();

        foreach ($locales as $locale) {
            $this->assertFileExists($this->path($locale));
            $this->assertFileExists($this->path($locale, 'auth.php'));
            $this->assertFileExists($this->path($locale, 'pagination.php'));
            $this->assertFileExists($this->path($locale, 'passwords.php'));
            $this->assertFileExists($this->path($locale, 'validation.php'));
            $this->assertDirectoryExists($this->path($locale, null, true));

            $this->artisan('lang:uninstall', ['locales' => $locale])->run();

            $this->assertFileDoesNotExist($this->path($locale));
            $this->assertFileDoesNotExist($this->path($locale, 'auth.php'));
            $this->assertFileDoesNotExist($this->path($locale, 'pagination.php'));
            $this->assertFileDoesNotExist($this->path($locale, 'passwords.php'));
            $this->assertFileDoesNotExist($this->path($locale, 'validation.php'));
            $this->assertDirectoryDoesNotExist($this->path($locale, null, true));
        }
    }

    public function testUninstalled()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $this->assertFileDoesNotExist($this->path($locale));
            $this->assertFileDoesNotExist($this->path($locale, 'auth.php'));
            $this->assertFileDoesNotExist($this->path($locale, 'pagination.php'));
            $this->assertFileDoesNotExist($this->path($locale, 'passwords.php'));
            $this->assertFileDoesNotExist($this->path($locale, 'validation.php'));
            $this->assertDirectoryDoesNotExist($this->path($locale, null, true));

            $this->artisan('lang:uninstall', ['locales' => $locale])->run();

            $this->assertFileDoesNotExist($this->path($locale));
            $this->assertFileDoesNotExist($this->path($locale, 'auth.php'));
            $this->assertFileDoesNotExist($this->path($locale, 'pagination.php'));
            $this->assertFileDoesNotExist($this->path($locale, 'passwords.php'));
            $this->assertFileDoesNotExist($this->path($locale, 'validation.php'));
            $this->assertDirectoryDoesNotExist($this->path($locale, null, true));
        }
    }

    public function testUninstallDefaultLocale()
    {
        $php_path  = Path::target($this->default_locale) . '/';
        $json_path = Path::target($this->default_locale, true) . '/';

        $this->artisan('lang:install', ['locales' => $this->default_locale, '--force' => true])->run();

        $this->assertFileExists($json_path . 'en.json');
        $this->assertFileExists($php_path . 'auth.php');
        $this->assertFileExists($php_path . 'pagination.php');
        $this->assertFileExists($php_path . 'passwords.php');
        $this->assertFileExists($php_path . 'validation.php');

        $this->artisan('lang:uninstall', ['locales' => $this->default_locale])->run();

        $this->assertFileExists($json_path . 'en.json');
        $this->assertFileExists($php_path . 'auth.php');
        $this->assertFileExists($php_path . 'pagination.php');
        $this->assertFileExists($php_path . 'passwords.php');
        $this->assertFileExists($php_path . 'validation.php');
    }
}
