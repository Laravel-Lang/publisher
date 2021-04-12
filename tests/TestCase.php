<?php

namespace Tests;

use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\LaravelLangPublisher\Support\Config;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $default_locale = 'en';

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

        $config->set(Config::KEY_PRIVATE . '.path.base', realpath(__DIR__ . '/../vendor/laravel-lang/lang/source'));
        $config->set(Config::KEY_PRIVATE . '.path.locales', realpath(__DIR__ . '/../vendor/laravel-lang/lang/locales'));

        $config->set(Config::KEY_PUBLIC . '.exclude', [
            'auth' => ['failed'],
            'All rights reserved.',
            'Baz',
        ]);
    }
}
