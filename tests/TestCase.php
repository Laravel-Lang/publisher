<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;
use function realpath;

abstract class TestCase extends BaseTestCase
{
    protected $default_locale = 'en';

    protected function tearDown(): void
    {
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
        $config->set('lang-publisher.exclude.auth', ['failed']);
        $config->set('app.locale', $this->default_locale);
    }

    protected function resetDefaultLangDirectory(): void
    {
        File::copyDirectory(
            Path::source($this->default_locale),
            Path::target($this->default_locale)
        );
    }

    protected function copyFixtures(): void
    {
        File::copy(
            realpath(__DIR__ . '/fixtures/auth.php'),
            Path::target($this->default_locale, 'auth.php')
        );
    }

    protected function deleteLocales(array $locales): void
    {
        foreach ($locales as $locale) {
            File::deleteDirectory(
                Path::target($locale)
            );
        }
    }
}
