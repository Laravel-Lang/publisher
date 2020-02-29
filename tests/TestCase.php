<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Contracts\Localization;
use Helldar\LaravelLangPublisher\Facades\Filesystem;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

use function realpath;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteLangDirectories();
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
        $dirs = new \DirectoryIterator(
            \resource_path('lang')
        );

        foreach ($dirs as $dir) {
            if ($dir->isDot() || $dir->getFilename() === Localization::DEFAULT_LOCALE) {
                continue;
            }

            Filesystem::deleteDirectory($dir->getRealPath());
        }
    }

    protected function copyFixtures()
    {
        Filesystem::copy(
            \realpath(__DIR__ . '/fixtures/auth.php'),
            \resource_path('lang/en/auth.php')
        );
    }
}
