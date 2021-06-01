<?php

namespace Tests\Console\Inline;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Concerns\Files;
use Helldar\LaravelLangPublisher\Concerns\Plugins;
use Helldar\LaravelLangPublisher\Exceptions\PackageDoesntExistsException;
use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleDoesntExistsException;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Services\Filesystem\Manager;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Support\Facades\Lang;
use Tests\TestCaseInline;

final class AddTest extends TestCaseInline
{
    use Containable;
    use Files;
    use Plugins;

    public function testCancelConfirmation()
    {
        $this->artisan('lang:add')
            ->expectsConfirmation('Do you want to add all localizations?')
            ->expectsChoice('What languages to add? (specify the necessary localizations separated by commas)', 'ar', Locales::available())
            ->assertExitCode(0)
            ->run();
    }

    public function testAcceptConfirmation()
    {
        $this->artisan('lang:add')
            ->expectsConfirmation('Do you want to add all localizations?')
            ->expectsChoice('What languages to add? (specify the necessary localizations separated by commas)', 'ar', Locales::available())
            ->assertExitCode(0)
            ->run();
    }

    public function testUnknownLanguageFromCommand()
    {
        $this->expectException(SourceLocaleDoesntExistsException::class);
        $this->expectExceptionMessage('The source "foo" localization was not found.');

        $locales = 'foo';

        $this->artisan('lang:add', compact('locales'));
    }

    public function testCanInstallWithoutForce()
    {
        $locales = ['de', 'ru', 'fr', 'zh_CN'];

        $nova_path  = $this->resources('lang/vendor/nova');
        $spark_path = $this->resources('lang/spark');

        $this->assertDirectoryDoesNotExist($nova_path);
        $this->assertDirectoryDoesNotExist($spark_path);

        foreach ($locales as $locale) {
            $path = $this->path($locale);

            $filename = $locale . '.json';

            $this->assertDirectoryDoesNotExist($path);

            $this->artisan('lang:add', ['locales' => $locale])->run();

            $this->assertDirectoryExists($path);
            $this->assertFileExists($nova_path . '/' . $filename);
        }

        $this->assertDirectoryExists($nova_path);
        $this->assertDirectoryExists($spark_path);
    }

    public function testCanInstallWithForce()
    {
        $this->copyFixtures();

        $this->artisan('lang:add', [
            'locales' => $this->default_locale,
            '--force' => true,
        ])->run();

        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', Lang::get('auth.throttle'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('Remember Me', Lang::get('Remember Me'));
    }

    public function testSkipped()
    {
        $this->copyFixtures();

        $this->artisan('lang:add', [
            'locales' => $this->default_locale,
        ])->run();

        $this->assertSame('Foo', Lang::get('auth.throttle'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('Remember Me', Lang::get('Remember Me'));
    }

    public function testExcludes()
    {
        $this->copyFixtures();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('This is Baq', Lang::get('Confirm Password'));

        Lang::setLoaded([]);

        $this->artisan('lang:add', [
            'locales' => $this->default_locale,
            '--force' => true,
        ])->run();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('All rights reserved.'));
        $this->assertSame('Confirm Password', Lang::get('Confirm Password'));
    }

    public function testIncorrectPackageName()
    {
        $this->expectException(PackageDoesntExistsException::class);
        $this->expectExceptionMessage('The "foo/bar" package is not a translation repository or does not exist.');

        $this->setPackages(['foo/bar']);

        $this->artisan('lang:add', ['locales' => $this->default_locale])->run();
    }

    public function testNotLocalized()
    {
        $this->expectException(PackageDoesntExistsException::class);
        $this->expectExceptionMessage('The "phpunit/phpunit" package is not a translation repository or does not exist.');

        $this->setPackages(['phpunit/phpunit']);

        $this->artisan('lang:add', ['locales' => $this->default_locale])->run();
    }

    public function testCheckInstalledKeys()
    {
        $this->emulatePaidPackages(true);

        $locales = Locales::available();

        $this->artisan('lang:add', [
            'locales' => $locales,
            '--force' => true,
        ])->run();

        foreach ($this->packages() as $package) {
            foreach ($locales as $locale) {
                $this->assertTrue(Locales::isInstalled($locale), 'Locale is not installed: ' . $locale);

                $this->filesTest($package, $locale);
                $this->pluginsTest($package, $locale);
            }
        }
    }

    protected function filesTest(string $package, string $locale): void
    {
        foreach ($this->files($package, $locale) as $filename) {
            $filename = $this->resolveLocaleFilename($locale, $filename);

            $this->fileTest($package, $locale, $filename);
        }
    }

    protected function pluginsTest(string $package, string $locale): void
    {
        foreach ($this->plugins() as $plugin) {
            foreach ($plugin->source() as $source) {
                $source_path = $this->pathSource($package, $locale) . '/' . $source;

                if (! file_exists($source_path)) {
                    continue;
                }

                $target = $plugin->targetPath($locale, $source);

                $this->fileTest($package, $locale, $source, $target);
            }
        }
    }

    protected function fileTest(string $package, string $locale, string $source, string $target = null): void
    {
        $target = $target ?: $source;

        $source_path = $this->pathSource($package, $locale) . '/' . $source;
        $target_path = $this->pathTargetFull($locale, $target);

        $source_array = $this->container(Manager::class)->load($source_path);
        $target_array = $this->container(Manager::class)->load($target_path);

        $source_array = Arr::ksort($source_array);
        $target_array = Arr::ksort($target_array);

        $this->assertNotEmpty($source_array, "The source array for $package, $locale, $source is empty!");
        $this->assertNotEmpty($target_array, "The target array for $package, $locale, $target is empty!");

        $diff = Arr::only($target_array, array_keys($source_array));

        $this->assertSame(array_keys($source_array), array_keys($diff), "Installed localization does not contain required source keys ($package, $locale, $source)!");
    }

    protected function resolveLocaleFilename(string $locale, string $filename): string
    {
        $directory = $this->pathDirectory($filename);
        $name      = $this->pathFilename($filename);
        $extension = $this->pathExtension($filename);

        $name = Locales::isAvailable($name) ? $locale : $name;

        $path = $directory . '/' . $name . '.' . $extension;

        return ltrim($path, '/');
    }
}
