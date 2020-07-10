<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Contracts\Pathable as PathableContract;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\LaravelLangPublisher\Services\Localization;
use Helldar\LaravelLangPublisher\Support\Path\Json as JsonPath;
use Helldar\LaravelLangPublisher\Support\Path\Php;
use Helldar\LaravelLangPublisher\Support\Path\Php as PhpPath;
use Helldar\LaravelLangPublisher\Traits\Containable;
use Helldar\LaravelLangPublisher\Traits\Containers\Pathable;
use Helldar\LaravelLangPublisher\Traits\Containers\Processable;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Containable;
    use Processable;
    use Pathable;

    /** @var string */
    protected $path;

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
            ? $app->bind(PathableContract::class, JsonPath::class)
            : $app->bind(PathableContract::class, PhpPath::class);
    }

    protected function resetDefaultLang(): void
    {
        if ($this->is_json) {
            File::copy(
                $this->path()->source($this->default_locale),
                $this->path()->target($this->default_locale)
            );

            return;
        }

        File::copyDirectory(
            $this->path()->source($this->default_locale),
            $this->path()->target($this->default_locale)
        );
    }

    protected function copyFixtures(): void
    {
        if ($this->is_json) {
            File::copy(
                realpath(__DIR__ . '/fixtures/en.json'),
                $this->path()->target($this->default_locale)
            );

            return;
        }

        File::copy(
            realpath(__DIR__ . '/fixtures/auth.php'),
            $this->path()->target($this->default_locale, 'auth.php')
        );
    }

    protected function deleteLocales(array $locales): void
    {
        foreach ($locales as $locale) {
            if ($this->is_json) {
                File::delete(
                    $this->path()->target($locale)
                );

                continue;
            }

            File::deleteDirectory(
                $this->path()->target($locale)
            );
        }
    }

    protected function localization(): Localization
    {
        return app(Localization::class);
    }

    protected function path(): PathableContract
    {
        return $this->container($this->path);
    }

    protected function isJson():bool {

    }
}
