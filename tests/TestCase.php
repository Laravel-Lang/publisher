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

namespace Tests;

use Helldar\LaravelLangPublisher\Concerns\Has;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Constants\Config;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Has;
    use Paths;

    protected $default = Locales::ENGLISH;

    protected $fallback = Locales::GERMAN;

    protected $locale = Locales::ALBANIAN;

    protected $locales = [
        LocalesList::BULGARIAN,
        LocalesList::DANISH,
        LocalesList::GALICIAN,
        LocalesList::ICELANDIC,
    ];

    protected $inline = true;

    protected $emulate = [
        'laravel/breeze',
        'laravel/fortify',
        'laravel/jetstream',
        'laravel/cashier',
        'laravel/nova',
        'laravel/spark-paddle',
        'laravel/spark-stripe',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->reinstallLocales();

        $this->emulatePackages();
    }

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('app.locale', $this->default);
        $config->set('app.fallback_locale', $this->fallback);

        $config->set(Config::PUBLIC_KEY . '.inline', $this->inline);

        $config->set(Config::PRIVATE_KEY . '.path.base', realpath(__DIR__ . '/../vendor'));

        $config->set(Config::PUBLIC_KEY . '.excludes', [
            'auth' => ['failed'],
            'json' => ['All rights reserved.', 'Baz'],
        ]);

        //$config->set(Config::PUBLIC_KEY . '.plugins', [
        //    'andrey-helldar/lang-translations',
        //]);
    }

    protected function copyFixtures(): void
    {
        $files = [
            'en.json',
            'auth.php',
            'validation.php',
        ];

        foreach ($files as $filename) {
            $from = realpath(__DIR__ . '/fixtures/' . $filename);

            $this->hasJson($filename)
                ? File::copy($from, $this->resourcesPath($filename))
                : File::copy($from, $this->resourcesPath($this->default . '/' . $filename));
        }
    }

    protected function refreshLocales(): void
    {
        app('translator')->setLoaded([]);
    }

    protected function reinstallLocales(): void
    {
        $this->deleteLocales();
        $this->installLocales();
    }

    protected function deleteLocales(): void
    {
        $path = $this->resourcesPath();

        Directory::ensureDelete($path);
    }

    protected function installLocales(): void
    {
        Artisan::call('lang:add', [
            'locales' => [$this->default, $this->fallback],
        ]);
    }

    protected function emulatePackages(): void
    {
        foreach ($this->emulate as $package) {
            $path = $this->vendorPath($package);

            Directory::ensureDirectory($path);
        }
    }
}
