<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests;

use DragonCode\Support\Facades\Filesystem\Directory;
use Illuminate\Support\Facades\App;
use Illuminate\Translation\TranslationServiceProvider;
use LaravelLang\JsonFallbackHotfix\TranslationServiceProvider as FixedTranslationServiceProvider;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Helpers\Config;
use LaravelLang\Publisher\ServiceProvider as PublisherServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Concerns\Commands;
use Tests\Fixtures\Plugin\src\ServiceProvider as PluginServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use Commands;

    protected ?Config $config;

    protected bool $inline = false;

    protected bool $smart_punctuation = false;

    /** @var array<string|LocaleCode> */
    protected array $preinstall = [];

    protected LocaleCode $locale = LocaleCode::ENGLISH;

    protected LocaleCode $fallback_locale = LocaleCode::FRENCH;

    protected function setUp(): void
    {
        parent::setUp();

        $this->init();

        $this->cleanUp();

        $this->copyFixtures();
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

    protected function overrideApplicationProviders($app): array
    {
        return [
            TranslationServiceProvider::class => FixedTranslationServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set(Config::PUBLIC_KEY . '.inline', $this->inline);
        $config->set(Config::PUBLIC_KEY . '.smart_punctuation.enable', $this->smart_punctuation);

        $config->set('app.locale', $this->locale->value);
        $config->set('app.fallback_locale', $this->fallback_locale->value);
    }

    protected function cleanUp(): void
    {
        $path = $this->config->langPath();

        Directory::ensureDelete($path);
        Directory::ensureDirectory($path);
    }

    protected function installLocales(): void
    {
        $this->artisanLangAdd(Locales::protects());
    }

    protected function preInstallLocales(): void
    {
        if ($locales = $this->preinstall) {
            $this->artisanLangAdd($locales);
        }
    }

    protected function setAppLocale(LocaleCode $locale): void
    {
        App::setLocale($locale->value);

        $this->reloadLocales();
    }

    protected function init(): void
    {
        $this->config = new Config();
    }

    protected function copyFixtures(): void
    {
        Directory::copy(__DIR__ . '/Fixtures/lang', $this->config->langPath());
    }

    protected function trans(string $key): string
    {
        return __($key);
    }

    protected function forceDeleteLocale(LocaleCode $locale): void
    {
        $this->artisanLangRemove($locale, true);

        $this->reloadLocales();
    }
}
