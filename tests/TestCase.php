<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Concerns\Pathable;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\LaravelLangPublisher\Support\Config;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Pathable;

    protected $default_locale = Locales::ENGLISH;

    protected $default_package = 'laravel-lang/lang';

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshLocales();
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

        $config->set(Config::KEY_PRIVATE . '.path.base', realpath(__DIR__ . '/../vendor'));

        $config->set(Config::KEY_PUBLIC . '.exclude', [
            'auth' => ['failed'],
            'json' => ['All rights reserved.', 'Baz'],
        ]);

        $config->set(Config::KEY_PUBLIC . '.packages', [
            'foo/bar',
            'phpunit/phpunit',
            'mockery/mockery',
            'andrey-helldar/lang-translations',
        ]);
    }

    protected function path(string $locale, string $filename = null, bool $directory = false): string
    {
        $is_json = empty($filename) && ! $directory;

        return Path::targetFull($locale, $filename, $is_json);
    }

    protected function copyFixtures(): void
    {
        File::copy(realpath(__DIR__ . '/fixtures/en.json'), $this->path($this->default_locale));
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
    }
}
