<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Helpers\Config;
use LaravelLang\Publisher\Helpers\Locales;
use LaravelLang\Publisher\ServiceProvider as PublisherServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\Plugin\src\ServiceProvider as PluginServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected ?Config $config;

    protected ?Locales $locales;

    protected bool $inline = false;

    /** @var array<string|LocaleCode> */
    protected array $preinstall = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->init();

        $this->cleanUp();

        $this->installLocales();
        $this->preInstallLocales();
    }

    protected function getPackageProviders($app): array
    {
        return [
            PublisherServiceProvider::class,
            PluginServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set(Config::PRIVATE_KEY . '.path.vendor', realpath(__DIR__ . '/../vendor'));

        $config->set(Config::PUBLIC_KEY . '.inline', $this->inline);
    }

    protected function cleanUp(): void
    {
        $path = $this->config->resourcesPath();

        Directory::ensureDelete($path);
        Directory::ensureDirectory($path);
    }

    protected function installLocales(): void
    {
        $this->artisan('lang:add', [
            'locales' => $this->locales->protects(),
        ])->run();
    }

    protected function preInstallLocales(): void
    {
        if ($locales = $this->preinstall) {
            $locales = Arr::of($locales)
                ->map(static fn (string|LocaleCode $locale) => is_string($locale) ? $locale : $locale->value)
                ->toArray();

            $this->artisan('lang:add', compact('locales'))->run();
        }
    }

    protected function init(): void
    {
        $this->config  = new Config();
        $this->locales = new Locales();
    }
}
