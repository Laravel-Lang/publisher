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

use Helldar\Contracts\LangPublisher\Plugin;
use Helldar\LaravelLangPublisher\Constants\Config as ConfigConst;
use Helldar\LaravelLangPublisher\Exceptions\UnknownPluginInstanceException;
use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\PrettyArray\Contracts\Caseable;
use Illuminate\Support\Facades\Config as Illuminate;
use LaravelLang\Lang\Publisher\Provider as LaravelLang;
use Tests\InlineOnTestCase;

class ConfigOnTest extends InlineOnTestCase
{
    public function testPlugins()
    {
        $this->assertSame([
            LaravelLang::class,
        ], Config::plugins());
    }

    public function testInvalidPlugins()
    {
        $this->expectException(UnknownPluginInstanceException::class);
        $this->expectExceptionMessage('The foo/bar class is not a ' . Plugin::class . ' instance.');

        Illuminate::set(ConfigConst::PUBLIC_KEY . '.plugins', [
            'foo/bar',
        ]);

        Config::plugins();
    }

    public function testExcludes()
    {
        $this->assertSame([
            'auth' => ['failed'],
            'json' => ['All rights reserved.', 'Baz'],
        ], Config::excludes());
    }

    public function testHasAlignment()
    {
        $this->assertTrue(Config::hasAlignment());
    }

    public function testHasInline()
    {
        $this->assertTrue(Config::hasInline());
    }

    public function testCase()
    {
        $actual = Config::case();

        $this->assertIsNumeric($actual);

        $this->assertSame(Caseable::NO_CASE, $actual);
    }

    public function testResources()
    {
        $expected = resource_path('lang');

        $this->assertSame($expected, Config::resources());
    }

    public function testVendor()
    {
        $expected = realpath(__DIR__ . '/../../vendor');

        $this->assertSame($expected, Config::vendor());
    }
}
