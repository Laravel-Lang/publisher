<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Tests\TestCase;

final class LocalesTest extends TestCase
{
    public function testProtects()
    {
        $locales = ['en', 'ko'];

        $this->assertSame($locales, Locales::protects());
    }

    public function testInstalled()
    {
        $locales = [
            LocalesList::AFRIKAANS,
            LocalesList::CHINESE_HONG_KONG,
            LocalesList::CZECH,
            LocalesList::BASQUE,
        ];

        $installed = [
            LocalesList::AFRIKAANS,
            LocalesList::CZECH,
            LocalesList::ENGLISH,
            LocalesList::BASQUE,
            LocalesList::KOREAN,
            LocalesList::CHINESE_HONG_KONG,
        ];

        $this->artisan('lang:add', compact('locales'))->run();

        $this->assertSame($installed, Locales::installed());
    }

    public function testIsInstalled()
    {
        $locales = [
            LocalesList::AFRIKAANS,
            LocalesList::CHINESE_HONG_KONG,
            LocalesList::CZECH,
            LocalesList::BASQUE,
        ];

        $installed = [
            LocalesList::AFRIKAANS,
            LocalesList::CZECH,
            LocalesList::ENGLISH,
            LocalesList::BASQUE,
            LocalesList::KOREAN,
            LocalesList::CHINESE_HONG_KONG,
        ];

        $this->artisan('lang:add', compact('locales'))->run();

        foreach ($installed as $locale) {
            $this->assertTrue(Locales::isInstalled($locale), 'Locale is not installed: ' . $locale);
        }
    }
}
