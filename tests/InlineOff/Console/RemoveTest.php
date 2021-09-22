<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Tests\InlineOff\Console;

use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Tests\InlineOffTestCase;

class RemoveTest extends InlineOffTestCase
{
    public function testWithoutLanguageAttribute()
    {
        $locale = 'ar';

        $this->artisan('lang:add', ['locales' => $locale])->run();

        $this->assertFileExists($this->resourcesPath($locale));
        $this->assertFileExists($this->resourcesPath($locale, 'auth.php'));
        $this->assertFileExists($this->resourcesPath($locale, 'pagination.php'));
        $this->assertFileExists($this->resourcesPath($locale, 'passwords.php'));
        $this->assertFileExists($this->resourcesPath($locale, 'validation.php'));
        $this->assertDirectoryExists($this->resourcesPath($locale));

        $this->artisan('lang:rm')
            ->expectsConfirmation('Do you want to remove all localizations?')
            ->expectsChoice('Select localizations to remove (specify the necessary localizations separated by commas):', 'ar', Locales::installed())
            ->assertExitCode(0);

        $this->assertFileDoesNotExist($this->resourcesPath($locale));
        $this->assertFileDoesNotExist($this->resourcesPath($locale, 'auth.php'));
        $this->assertFileDoesNotExist($this->resourcesPath($locale, 'pagination.php'));
        $this->assertFileDoesNotExist($this->resourcesPath($locale, 'passwords.php'));
        $this->assertFileDoesNotExist($this->resourcesPath($locale, 'validation.php'));
        $this->assertDirectoryDoesNotExist($this->resourcesPath($locale));
    }

    public function testUninstall()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        $this->artisan('lang:add', ['locales' => $locales, '--force' => true])->run();

        foreach ($locales as $locale) {
            $this->assertFileExists($this->resourcesPath($locale));
            $this->assertFileExists($this->resourcesPath($locale, 'auth.php'));
            $this->assertFileExists($this->resourcesPath($locale, 'pagination.php'));
            $this->assertFileExists($this->resourcesPath($locale, 'passwords.php'));
            $this->assertFileExists($this->resourcesPath($locale, 'validation.php'));
            $this->assertDirectoryExists($this->resourcesPath($locale));

            $this->artisan('lang:rm', ['locales' => $locale])->run();

            $this->assertFileDoesNotExist($this->resourcesPath($locale));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'auth.php'));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'pagination.php'));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'passwords.php'));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'validation.php'));
            $this->assertDirectoryDoesNotExist($this->resourcesPath($locale));
        }
    }

    public function testUninstalled()
    {
        $locales = ['bg', 'da', 'gl', 'is'];

        foreach ($locales as $locale) {
            $this->assertFileDoesNotExist($this->resourcesPath($locale));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'auth.php'));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'pagination.php'));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'passwords.php'));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'validation.php'));
            $this->assertDirectoryDoesNotExist($this->resourcesPath($locale));

            $this->artisan('lang:rm', ['locales' => $locale])->run();

            $this->assertFileDoesNotExist($this->resourcesPath($locale));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'auth.php'));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'pagination.php'));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'passwords.php'));
            $this->assertFileDoesNotExist($this->resourcesPath($locale, 'validation.php'));
            $this->assertDirectoryDoesNotExist($this->resourcesPath($locale));
        }
    }

    public function testUninstallDefaultLocale()
    {
        $path = $this->resourcesPath($this->default);

        $this->artisan('lang:add', ['locales' => $this->default, '--force' => true])->run();

        $this->assertFileExists($path . 'en.json');
        $this->assertFileExists($path . '/auth.php');
        $this->assertFileExists($path . '/pagination.php');
        $this->assertFileExists($path . '/passwords.php');
        $this->assertFileExists($path . '/validation.php');

        $this->artisan('lang:rm', ['locales' => $this->default])->run();

        $this->assertFileExists($path . 'en.json');
        $this->assertFileExists($path . '/auth.php');
        $this->assertFileExists($path . '/pagination.php');
        $this->assertFileExists($path . '/passwords.php');
        $this->assertFileExists($path . '/validation.php');
    }
}
