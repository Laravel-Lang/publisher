<?php

namespace Tests;

use Helldar\LaravelLangPublisher\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config as IlluminateConfig;
use Orchestra\Testbench\TestCase as BaseTestCase;

use function array_merge;
use function ltrim;
use function realpath;

abstract class TestCase extends BaseTestCase
{
    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    protected $default_locale = 'en';

    protected function setUp(): void
    {
        $this->setFilesystem();
        $this->resetConfig();
        $this->deleteLangDirectories();
        $this->resetDefaultLangDirectory();

        parent::setUp();
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

    protected function deleteLangDirectories(): void
    {
        if ($path = $this->getLaravelPath('resources/lang')) {
            $this->fs->deleteDirectory($path);
        }
    }

    protected function resetDefaultLangDirectory(): void
    {
        $path = __DIR__ . '/../vendor/caouecs/laravel-lang/';

        $src = $this->default_locale === 'en'
            ? $path . 'script/en'
            : $path . 'src/' . $this->default_locale;

        $dst = $this->getLaravelPath('resources/lang/' . $this->default_locale, false);

        $this->fs->copyDirectory($src, $dst);
    }

    protected function setFilesystem(): void
    {
        $this->fs = new Filesystem();
    }

    protected function resetConfig(): void
    {
        if ($path = $this->getLaravelPath('config/lang-publisher.php')) {
            $this->fs->delete($path);
        }
    }

    protected function copyFixtures(): void
    {
        $this->fs->copy(
            realpath(__DIR__ . '/fixtures/auth.php'),
            $this->getLaravelPath("resources/lang/{$this->default_locale}/auth.php")
        );
    }

    protected function setFixtureConfig(): void
    {
        $config  = IlluminateConfig::get('lang-publisher', []);
        $content = require realpath(__DIR__ . '/fixtures/config.php');

        IlluminateConfig::set('lang-publisher', array_merge($config, $content));
    }

    protected function getLaravelPath(string $path, bool $use_real = true): ?string
    {
        $path = __DIR__ . '/../vendor/orchestra/testbench-core/laravel' . $this->cleanPath($path);

        return $use_real ? realpath($path) : $path;
    }

    protected function cleanPath(string $path): string
    {
        return $path
            ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR)
            : $path;
    }
}
