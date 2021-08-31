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

namespace Tests\InlineOn\Support;

use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Illuminate\Support\Facades\Artisan;
use Tests\InlineTestCase;

class LocalesTest extends InlineTestCase
{
    public function testIsInstalled()
    {
        $this->assertTrue(Locales::isInstalled(LocalesList::ENGLISH));
        $this->assertTrue(Locales::isInstalled(LocalesList::KOREAN));

        $this->assertFalse(Locales::isInstalled(LocalesList::FRENCH));
        $this->assertFalse(Locales::isInstalled(LocalesList::GERMAN));
        $this->assertFalse(Locales::isInstalled(LocalesList::RUSSIAN));
    }

    public function testIsProtected()
    {
        $this->assertTrue(Locales::isProtected(LocalesList::ENGLISH));
        $this->assertTrue(Locales::isProtected(LocalesList::KOREAN));

        $this->assertFalse(Locales::isProtected(LocalesList::FRENCH));
        $this->assertFalse(Locales::isProtected(LocalesList::GERMAN));
        $this->assertFalse(Locales::isProtected(LocalesList::RUSSIAN));
    }

    public function testAvailable()
    {
        $expected = [
            'af',
            'ar',
            'az',
            'be',
            'bg',
            'bn',
            'bs',
            'cs',
            'cy',
            'da',
            'de',
            'de_CH',
            'el',
            'en',
            'es',
            'et',
            'eu',
            'fa',
            'fi',
            'fil',
            'fr',
            'he',
            'hi',
            'hr',
            'hu',
            'hy',
            'id',
            'is',
            'it',
            'ja',
            'ka',
            'kk',
            'km',
            'kn',
            'ko',
            'lt',
            'lv',
            'mk',
            'mn',
            'mr',
            'ms',
            'nb',
            'ne',
            'nl',
            'nn',
            'oc',
            'pl',
            'ps',
            'pt',
            'pt_BR',
            'ro',
            'ru',
            'sc',
            'si',
            'sk',
            'sl',
            'sq',
            'sr_Cyrl',
            'sr_Latn',
            'sr_Latn_ME',
            'sv',
            'sw',
            'tg',
            'th',
            'tk',
            'tl',
            'tr',
            'ug',
            'uk',
            'ur',
            'uz_Cyrl',
            'uz_Latn',
            'vi',
            'zh_CN',
            'zh_HK',
            'zh_TW',
        ];

        $this->assertSame($expected, Locales::available());
    }

    public function testIsAvailable()
    {
        $this->assertTrue(Locales::isAvailable(LocalesList::ENGLISH));
        $this->assertTrue(Locales::isAvailable(LocalesList::KOREAN));

        $this->assertFalse(Locales::isAvailable('foo'));
        $this->assertFalse(Locales::isAvailable('bar'));
        $this->assertFalse(Locales::isAvailable('baz'));
    }

    public function testProtects()
    {
        $expected = [
            LocalesList::ENGLISH,
            LocalesList::KOREAN,
        ];

        $this->assertSame($expected, Locales::protects());
    }

    public function testInstalled()
    {
        $expected1 = [
            LocalesList::ENGLISH,
            LocalesList::KOREAN,
        ];

        $expected2 = [
            LocalesList::BULGARIAN,
            LocalesList::DANISH,
            LocalesList::ENGLISH,
            LocalesList::GALICIAN,
            LocalesList::ICELANDIC,
            LocalesList::KOREAN,
        ];

        $this->assertSame($expected1, Locales::installed());

        Artisan::call('lang:add', [
            'locales' => [
                LocalesList::BULGARIAN,
                LocalesList::DANISH,
                LocalesList::GALICIAN,
                LocalesList::ICELANDIC,
            ],
        ]);

        $this->assertSame($expected2, Locales::installed());
    }

    public function testGetDefault()
    {
        $this->assertSame(LocalesList::ENGLISH, Locales::getDefault());
    }

    public function testGetFallback()
    {
        $this->assertSame(LocalesList::KOREAN, Locales::getFallback());
    }
}
