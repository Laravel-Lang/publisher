<?php

namespace Tests;

use function config_path;
use DirectoryIterator;
use Helldar\LaravelLangPublisher\Contracts\Localization;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Illuminate\Support\Facades\File;

use Orchestra\Testbench\TestCase as BaseTestCase;
use function realpath;
use function resource_path;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteLangDirectories();
        $this->resetDefaultLangDirectory();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('lang-publisher', [
            'vendor' => realpath('../../vendor/caouecs/laravel-lang/src'),
        ]);
    }

    protected function deleteLangDirectories(): void
    {
        $dirs = new DirectoryIterator(
            resource_path('lang')
        );

        foreach ($dirs as $dir) {
            if ($dir->isDot() || $dir->getFilename() === Localization::DEFAULT_LOCALE) {
                continue;
            }

            File::deleteDirectory($dir->getRealPath());
        }
    }

    protected function resetDefaultLangDirectory()
    {
        $this->artisan('lang:install', [
            'lang'    => ['en'],
            '--force' => true,
        ]);
    }

    protected function copyFixtures()
    {
        File::copy(
            realpath(__DIR__ . '/fixtures/auth.php'),
            resource_path('lang/en/auth.php')
        );
    }

    protected function copyConfig()
    {
        File::copy(
            realpath(__DIR__ . '/fixtures/config.php'),
            config_path('lang-publisher.php')
        );
    }
}
