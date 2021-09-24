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

namespace Tests\InlineOff\Helpers;

use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Exceptions\SourceLocaleDoesntExistsException;
use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Tests\InlineOffTestCase;

class LocalesTest extends InlineOffTestCase
{
    public function testProtects()
    {
        $locales = Locales::protects();

        $this->assertSame([
            LocalesList::ENGLISH,
            LocalesList::GERMAN,
        ], $locales);
    }

    public function testAvailable()
    {
        $locales = Locales::available();

        $expected = $this->getAllLocales();

        $this->assertSame($expected, $locales);
    }

    public function testInstalled()
    {
        $locales = Locales::installed();

        $this->assertSame([
            LocalesList::GERMAN,
            LocalesList::ENGLISH,
        ], $locales);
    }

    public function testGetDefault()
    {
        $locale = Locales::getDefault();

        $this->assertSame($this->default, $locale);
    }

    public function testGetFallback()
    {
        $locale = Locales::getFallback();

        $this->assertSame($this->fallback, $locale);
    }

    public function testIsInstalled()
    {
        $this->assertTrue(Locales::isInstalled(LocalesList::ENGLISH));
        $this->assertTrue(Locales::isInstalled(LocalesList::GERMAN));

        $this->assertFalse(Locales::isInstalled(LocalesList::ROMANIAN));
        $this->assertFalse(Locales::isInstalled(LocalesList::UIGHUR));
    }

    public function testIsAvailable()
    {
        foreach ($this->getAllLocales() as $locale) {
            $message = sprintf('%s localization not available', $locale);

            $this->assertTrue(Locales::isAvailable($locale), $message);
        }

        $this->assertFalse(Locales::isAvailable('foo'));
        $this->assertFalse(Locales::isAvailable('bar'));
    }

    public function testIsProtected()
    {
        $this->assertTrue(Locales::isProtected(LocalesList::ENGLISH));
        $this->assertTrue(Locales::isProtected(LocalesList::GERMAN));

        $this->assertFalse(Locales::isProtected(LocalesList::ROMANIAN));
        $this->assertFalse(Locales::isProtected(LocalesList::UIGHUR));
    }

    public function testValidateSuccess()
    {
        Locales::validate($this->default);
        Locales::validate($this->fallback);

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(SourceLocaleDoesntExistsException::class);
        $this->expectExceptionMessage('The source "foo" localization was not found');

        Locales::validate('foo');
    }
}
