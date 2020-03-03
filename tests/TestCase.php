<?php

namespace Tests;

use Helldar\LaravelLangPublisher\ServiceProvider;
use Illuminate\Support\Facades\Config as IlluminateConfig;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

use function array_merge;
use function config_path;
use function realpath;
use function resource_path;

abstract class TestCase extends BaseTestCase
{
    protected $default_locale = 'en';

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetConfig();
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
        $config->set('app.locale', $this->default_locale);
    }

    protected function resetConfig(): void
    {
        File::delete(
            config_path('lang-publisher.php')
        );
    }

    protected function deleteLangDirectories(): void
    {
        $dir = resource_path('lang');

        File::deleteDirectory($dir);
        File::makeDirectory($dir);
    }

    protected function resetDefaultLangDirectory(): void
    {
        $path = __DIR__ . '/../vendor/caouecs/laravel-lang/';

        $src = $this->default_locale === 'en'
            ? $path . 'script/en'
            : $path . 'src/' . $this->default_locale;

        File::copyDirectory(
            $src,
            resource_path('lang/' . $this->default_locale)
        );
    }

    protected function copyFixtures(): void
    {
        File::copy(
            realpath(__DIR__ . '/fixtures/auth.php'),
            resource_path("lang/{$this->default_locale}/auth.php")
        );
    }

    protected function setFixtureConfig(): void
    {
        $config  = IlluminateConfig::get('lang-publisher', []);
        $content = require realpath(__DIR__ . '/fixtures/config.php');

        IlluminateConfig::set('lang-publisher', array_merge($config, $content));
    }
}
