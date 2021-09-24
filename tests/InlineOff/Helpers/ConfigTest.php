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

use Helldar\Contracts\LangPublisher\Plugin;
use Helldar\Contracts\LangPublisher\Provider;
use Helldar\LaravelLangPublisher\Constants\Config as Names;
use Helldar\LaravelLangPublisher\Exceptions\UnknownPluginInstanceException;
use Helldar\LaravelLangPublisher\Facades\Helpers\Config;
use Helldar\PrettyArray\Contracts\Caseable;
use Illuminate\Support\Facades\Config as Illuminate;
use Tests\InlineOffTestCase;

class ConfigTest extends InlineOffTestCase
{
    public function testVendor()
    {
        $config = Config::vendor();

        $path = realpath(__DIR__ . '/../../../vendor');

        $this->assertSame($path, $config);
    }

    public function testCase()
    {
        $config = Config::case();

        $this->assertIsNumeric($config);

        $this->assertSame(Caseable::NO_CASE, $config);
    }

    public function testHasInline()
    {
        $config = Config::hasInline();

        $this->assertFalse($config);
    }

    public function testHasAlignment()
    {
        $config = Config::hasAlignment();

        $this->assertTrue($config);
    }

    public function testExcludes()
    {
        $config = Config::excludes();

        $this->assertSame([
            'auth' => ['failed'],
            'json' => ['All rights reserved.', 'Baz'],
        ], $config);
    }

    public function testResources()
    {
        $config = Config::resources();

        $path = resource_path('lang');

        $this->assertSame($path, $config);
    }

    public function testPlugins()
    {
        $config = Config::plugins();

        $this->assertIsArray($config);

        foreach ($config as $item) {
            $message = sprintf('Failed asserting that %s is an instance of class %s', get_class($item), Provider::class);

            $this->assertInstanceOf(Provider::class, $item, $message);
        }
    }

    public function testTestIncorrectPlugins()
    {
        $this->expectException(UnknownPluginInstanceException::class);

        $this->expectExceptionMessage(
            sprintf('The foo class is not a %s instance', Plugin::class)
        );

        Illuminate::set(Names::PUBLIC_KEY . '.plugins', ['foo']);

        Config::plugins();
    }
}
