<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Tests;

use Helldar\LaravelLangPublisher\Concerns\Has;
use Helldar\LaravelLangPublisher\Concerns\Paths;
use Helldar\LaravelLangPublisher\Constants\Config;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Concerns\Asserts;
use Tests\Providers\Provider;

abstract class TestCase extends BaseTestCase
{
    use Asserts;
    use Has;
    use Paths;

    protected $default = Locales::ENGLISH;

    protected $fallback = Locales::GERMAN;

    protected $locale = Locales::RUSSIAN;

    protected $locales = [
        LocalesList::BULGARIAN,
        LocalesList::DANISH,
        LocalesList::GALICIAN,
        LocalesList::ICELANDIC,
    ];

    protected $inline = true;

    protected $emulate = [
        'laravel/breeze',
        'laravel/fortify',
        'laravel/jetstream',
        'laravel/cashier',
        'laravel/nova',
        'laravel/spark-paddle',
        'laravel/spark-stripe',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->reinstallLocales();

        $this->emulatePackages();
    }

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('app.locale', $this->default);
        $config->set('app.fallback_locale', $this->fallback);

        $config->set(Config::PUBLIC_KEY . '.inline', $this->inline);

        $config->set(Config::PRIVATE_KEY . '.path.base', realpath(__DIR__ . '/../vendor'));

        $config->set(Config::PUBLIC_KEY . '.excludes', [
            'auth' => ['failed'],

            '{locale}' => ['All rights reserved.', 'Baz'],
        ]);

        $config->set(Config::PRIVATE_KEY . '.plugins', [
            Provider::class,
        ]);
    }

    protected function copyFixtures(): void
    {
        $files = [
            'en.json',
            'auth.php',
            'validation.php',
        ];

        foreach ($files as $filename) {
            $from = realpath(__DIR__ . '/fixtures/' . $filename);

            $this->hasJson($filename)
                ? File::copy($from, $this->resourcesPath($filename))
                : File::copy($from, $this->resourcesPath($this->default . '/' . $filename));
        }
    }

    protected function refreshLocales(): void
    {
        app('translator')->setLoaded([]);
    }

    protected function reinstallLocales(): void
    {
        $this->deleteLocales();
        $this->installLocales();
    }

    protected function deleteLocales(): void
    {
        $path = $this->resourcesPath();

        Directory::ensureDelete($path);
    }

    protected function installLocales(): void
    {
        $this->artisan('lang:add', [
            'locales' => [$this->default, $this->fallback],
        ])->run();
    }

    protected function emulatePackages(): void
    {
        foreach ($this->emulate as $package) {
            $path = $this->vendorPath($package);

            Directory::ensureDirectory($path);
        }
    }

    protected function getAllLocales(): array
    {
        return Arr::sort([
            LocalesList::AFRIKAANS,
            LocalesList::ALBANIAN,
            LocalesList::ARABIC,
            LocalesList::ARMENIAN,
            LocalesList::AZERBAIJANI,
            LocalesList::BASQUE,
            LocalesList::BELARUSIAN,
            LocalesList::BENGALI,
            LocalesList::BOSNIAN,
            LocalesList::BULGARIAN,
            LocalesList::CATALAN,
            LocalesList::CENTRAL_KHMER,
            LocalesList::CHINESE,
            LocalesList::CHINESE_HONG_KONG,
            LocalesList::CHINESE_T,
            LocalesList::CROATIAN,
            LocalesList::CZECH,
            LocalesList::DANISH,
            LocalesList::DUTCH,
            LocalesList::ENGLISH,
            LocalesList::ESTONIAN,
            LocalesList::FINNISH,
            LocalesList::FRENCH,
            LocalesList::GALICIAN,
            LocalesList::GEORGIAN,
            LocalesList::GERMAN,
            LocalesList::GERMAN_SWITZERLAND,
            LocalesList::GREEK,
            LocalesList::GUJARATI,
            LocalesList::HEBREW,
            LocalesList::HINDI,
            LocalesList::HUNGARIAN,
            LocalesList::ICELANDIC,
            LocalesList::INDONESIAN,
            LocalesList::ITALIAN,
            LocalesList::JAPANESE,
            LocalesList::KANNADA,
            LocalesList::KAZAKH,
            LocalesList::KOREAN,
            LocalesList::LATVIAN,
            LocalesList::LITHUANIAN,
            LocalesList::MACEDONIAN,
            LocalesList::MALAY,
            LocalesList::MARATHI,
            LocalesList::MONGOLIAN,
            LocalesList::NEPALI,
            LocalesList::NORWEGIAN_BOKMAL,
            LocalesList::NORWEGIAN_NYNORSK,
            LocalesList::OCCITAN,
            LocalesList::PASHTO,
            LocalesList::PERSIAN,
            LocalesList::PILIPINO,
            LocalesList::POLISH,
            LocalesList::PORTUGUESE,
            LocalesList::PORTUGUESE_BRAZIL,
            LocalesList::ROMANIAN,
            LocalesList::RUSSIAN,
            LocalesList::SARDINIAN,
            LocalesList::SERBIAN_CYRILLIC,
            LocalesList::SERBIAN_LATIN,
            LocalesList::SERBIAN_MONTENEGRIN,
            LocalesList::SINHALA,
            LocalesList::SLOVAK,
            LocalesList::SLOVENIAN,
            LocalesList::SPANISH,
            LocalesList::SWAHILI,
            LocalesList::SWEDISH,
            LocalesList::TAGALOG,
            LocalesList::TAJIK,
            LocalesList::THAI,
            LocalesList::TURKISH,
            LocalesList::TURKMEN,
            LocalesList::UIGHUR,
            LocalesList::UKRAINIAN,
            LocalesList::URDU,
            LocalesList::UZBEK_CYRILLIC,
            LocalesList::UZBEK_LATIN,
            LocalesList::VIETNAMESE,
            LocalesList::WELSH,
        ]);
    }
}
