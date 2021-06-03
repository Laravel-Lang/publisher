<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Concerns\Containable;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Concerns\Pathable;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;
use Helldar\LaravelLangPublisher\Facades\Packages;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\LaravelLangPublisher\Services\Filesystem\Manager;
use Helldar\LaravelLangPublisher\Support\Config;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Illuminate\Support\Facades\Config as IlluminateConfig;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Containable;
    use Logger;
    use Pathable;

    protected $default_locale = Locales::ENGLISH;

    protected $fallback_locale = Locales::KOREAN;

    protected $default_package = 'laravel-lang/lang';

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshLocales();

        $this->emulateFreePackages();
        $this->emulatePaidPackages();
    }

    protected function tearDown(): void
    {
        $this->removeEmulatedPackages();

        parent::tearDown();
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('app.locale', $this->default_locale);
        $config->set('app.fallback_locale', $this->fallback_locale);

        $config->set(Config::KEY_PRIVATE . '.path.base', realpath(__DIR__ . '/../vendor'));

        $config->set(Config::KEY_PUBLIC . '.exclude', [
            'auth' => ['failed'],
            'json' => ['All rights reserved.', 'Baz'],
        ]);

        $config->set(Config::KEY_PUBLIC . '.packages', [
            'andrey-helldar/lang-translations',
        ]);
    }

    protected function path(string $locale, string $filename = null): string
    {
        return Path::targetFull($locale, $filename);
    }

    protected function resources(string $path): string
    {
        return resource_path($path);
    }

    protected function copyFixtures(): void
    {
        File::copy(realpath(__DIR__ . '/fixtures/en.json'), $this->path($this->default_locale, 'en.json'));
        File::copy(realpath(__DIR__ . '/fixtures/auth.php'), $this->path($this->default_locale, 'auth.php'));
    }

    protected function refreshLocales(): void
    {
        $this->deleteLocales();
        $this->installLocale();
    }

    protected function deleteLocales(): void
    {
        File::deleteDirectory(ConfigFacade::resourcesPath());
    }

    protected function installLocale(): void
    {
        $source = $this->pathSource($this->default_package, $this->default_locale);
        $target = $this->pathTarget($this->default_locale);

        File::copyDirectory($source, $target);

        File::move($target . '/en.json', $target . '/../en.json');

        File::delete($target . '/validation-inline.php');
        File::deleteDirectory($target . '/packages');

        $this->container(Manager::class)->ensureKeys($target . '/../en.json');
    }

    protected function emulateFreePackages(): void
    {
        Directory::ensureDirectory($this->pathVendor() . '/laravel/fortify');
        Directory::ensureDirectory($this->pathVendor() . '/laravel/jetstream');
    }

    protected function emulatePaidPackages(bool $full = false): void
    {
        Directory::ensureDirectory($this->pathVendor() . '/laravel/spark-stripe');
        Directory::ensureDirectory($this->pathVendor() . '/laravel/nova');

        if ($full) {
            Directory::ensureDirectory($this->pathVendor() . '/laravel/cashier');
            Directory::ensureDirectory($this->pathVendor() . '/laravel/spark-paddle');
        }
    }

    protected function removeEmulatedPackages(): void
    {
        $names = [
            '/laravel/cashier',
            '/laravel/fortify',
            '/laravel/jetstream',
            '/laravel/nova',
            '/laravel/spark-paddle',
            '/laravel/spark-stripe',
        ];

        foreach ($names as $name) {
            $path = $this->pathVendor() . $name;

            if (Directory::exists($path)) {
                Directory::delete($path);
            }
        }
    }

    protected function setPackages(array $packages): void
    {
        $key = Config::KEY_PUBLIC;

        IlluminateConfig::set($key . '.packages', $packages);
    }

    protected function packages(): array
    {
        return Packages::get();
    }
}
