<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests;

use DragonCode\Support\Facades\Filesystem\Directory;
use Illuminate\Support\Facades\App;
use Illuminate\Translation\TranslationServiceProvider;
use LaravelLang\Config\Enums\Name;
use LaravelLang\Config\ServiceProvider as ConfigServiceProvider;
use LaravelLang\JsonFallback\TranslationServiceProvider as FixedTranslationServiceProvider;
use LaravelLang\LocaleList\Locale;
use LaravelLang\Locales\Facades\Locales;
use LaravelLang\Locales\ServiceProvider as LocalesServiceProvider;
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

    protected bool $smartPunctuation = false;

    /** @var array<string|Locale> */
    protected array $preinstall = [];

    protected Locale $locale = Locale::English;

    protected Locale $fallbackLocale = Locale::French;

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
            ConfigServiceProvider::class,
            LocalesServiceProvider::class,
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

    protected function getEnvironmentSetUp($app): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set(Name::Shared() . '.inline', $this->inline);
        $config->set(Name::Shared() . '.smart_punctuation.enable', $this->smartPunctuation);

        $config->set('app.locale', $this->locale->value);
        $config->set('app.fallback_locale', $this->fallbackLocale->value);
    }

    protected function cleanUp(): void
    {
        $path = $this->config->langPath();

        Directory::ensureDelete($path);
        Directory::ensureDirectory($path);
    }

    protected function installLocales(): void
    {
        $this->artisanLangAdd(Locales::raw()->protects());
    }

    protected function preInstallLocales(): void
    {
        if ($locales = $this->preinstall) {
            $this->artisanLangAdd($locales);
        }
    }

    protected function setAppLocale(Locale $locale): void
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

    protected function forceDeleteLocale(Locale $locale): void
    {
        $this->artisanLangRemove($locale, true);

        $this->reloadLocales();
    }
}
