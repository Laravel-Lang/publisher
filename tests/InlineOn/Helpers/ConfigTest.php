<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
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
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\InlineOn\Helpers;

use DragonCode\Contracts\LangPublisher\Plugin;
use DragonCode\Contracts\LangPublisher\Provider;
use DragonCode\Contracts\Pretty\Arr\Caseable;
use Illuminate\Support\Facades\Config as Illuminate;
use LaravelLang\Publisher\Constants\Config as Names;
use LaravelLang\Publisher\Exceptions\UnknownPluginInstanceException;
use LaravelLang\Publisher\Facades\Helpers\Config;
use Tests\InlineOnTestCase;

class ConfigTest extends InlineOnTestCase
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

        $this->assertTrue($config);
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
            'auth'     => ['failed'],
            '{locale}' => ['All rights reserved.', 'Baz'],
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
