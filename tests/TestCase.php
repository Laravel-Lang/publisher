<?php

namespace Tests;

use function app;
use function array_merge;
use Helldar\LaravelLangPublisher\Contracts\Filesystem;
use Helldar\LaravelLangPublisher\Contracts\Localization;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Illuminate\Support\Facades\Config;

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

        $config->set('lang-publisher.vendor', realpath(__DIR__ . '/../vendor/caouecs/laravel-lang/src'));
    }

    protected function deleteLangDirectories(): void
    {
        File::deleteDirectory(
            resource_path('lang')
        );
    }

    protected function resetDefaultLangDirectory()
    {
        /** @var \Helldar\LaravelLangPublisher\Contracts\Filesystem $fs */
        $fs = app(Filesystem::class);

        File::copyDirectory(
            $fs->caouecsPath('../script/en'),
            $fs->translationsPath(Localization::DEFAULT_LOCALE)
        );
    }

    protected function copyFixtures()
    {
        File::copy(
            realpath(__DIR__ . '/fixtures/auth.php'),
            resource_path('lang/en/auth.php')
        );
    }

    protected function setFixtureConfig()
    {
        $config  = Config::get('lang-publisher', []);
        $content = require realpath(__DIR__ . '/fixtures/config.php');

        Config::set('lang-publisher', array_merge($config, $content));
    }
}
