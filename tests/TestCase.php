<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Contracts\Pathable;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\LaravelLangPublisher\Services\Localization;
use Helldar\LaravelLangPublisher\Support\Path\Json;
use Helldar\LaravelLangPublisher\Support\Path\Json as JsonPath;
use Helldar\LaravelLangPublisher\Support\Path\Php as PhpPath;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $default_locale = 'en';

    protected $is_json = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetDefaultLang();
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

        $config->set('lang-publisher.vendor', realpath(__DIR__ . '/../vendor/caouecs/laravel-lang'));
        $config->set('app.locale', $this->default_locale);

        $this->is_json
            ? $config->set('lang-publisher.exclude', ['All rights reserved.'])
            : $config->set('lang-publisher.exclude.auth', ['failed']);

        $this->is_json
            ? $app->bind(Pathable::class, JsonPath::class)
            : $app->bind(Pathable::class, PhpPath::class);
    }

    protected function resetDefaultLang(): void
    {
        if ($this->is_json) {
            File::copy(
                Path::source($this->default_locale),
                Path::target($this->default_locale)
            );

            return;
        }

        File::copyDirectory(
            Path::source($this->default_locale),
            Path::target($this->default_locale)
        );
    }

    protected function copyFixtures(): void
    {
        if ($this->is_json) {
            File::copy(
                realpath(__DIR__ . '/fixtures/en.json'),
                Path::target($this->default_locale)
            );

            return;
        }

        File::copy(
            realpath(__DIR__ . '/fixtures/auth.php'),
            Path::target($this->default_locale, 'auth.php')
        );
    }

    protected function deleteLocales(array $locales): void
    {
        foreach ($locales as $locale) {
            if ($this->is_json) {
                File::delete(
                    Path::target($locale)
                );

                continue;
            }

            File::deleteDirectory(
                Path::target($locale)
            );
        }
    }

    protected function localization(): Localization
    {
        return app(Localization::class);
    }
}
