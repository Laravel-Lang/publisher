<?php

namespace Tests\Console;

use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\Locales;
use Helldar\LaravelLangPublisher\Facades\Packages;
use Helldar\LaravelLangPublisher\Support\Config as SupportConfig;
use Illuminate\Support\Facades\Config as IlluminateConfig;
use Tests\TestCase;

final class ConfigTest extends TestCase
{
    public function testIgnore(): void
    {
        $this->assertEmpty(Config::ignores());

        $this->assertTrue(in_array('ru', Locales::available()));
        $this->assertTrue(in_array('de', Locales::available()));
        $this->assertTrue(in_array('fr', Locales::available()));
        $this->assertTrue(in_array('en', Locales::available()));

        IlluminateConfig::set(SupportConfig::KEY_PUBLIC . '.ignore', ['ru']);

        $this->assertNotEmpty(Config::ignores());

        $this->assertFalse(in_array('ru', Locales::available()));
        $this->assertTrue(in_array('de', Locales::available()));
        $this->assertTrue(in_array('fr', Locales::available()));
        $this->assertTrue(in_array('en', Locales::available()));
    }

    public function testAllPackages(): void
    {
        $packages = [
            'andrey-helldar/lang-translations',
            'foo/bar',
            'laravel-lang/lang',
            'mockery/mockery',
            'phpunit/phpunit',
        ];

        $this->assertSame($packages, Packages::all());
    }

    public function testFilteredPackages(): void
    {
        $packages = [
            'andrey-helldar/lang-translations',
            'laravel-lang/lang',
        ];

        $this->assertSame($packages, Packages::filtered());
    }
}
