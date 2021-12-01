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

namespace Tests\Main;

use LaravelLang\Lang\Publisher\Plugins\Breeze;
use LaravelLang\Lang\Publisher\Plugins\Cashier;
use LaravelLang\Lang\Publisher\Plugins\Fortify;
use LaravelLang\Lang\Publisher\Plugins\Jetstream;
use LaravelLang\Lang\Publisher\Plugins\Laravel;
use LaravelLang\Lang\Publisher\Plugins\Lumen;
use LaravelLang\Lang\Publisher\Plugins\Nova;
use LaravelLang\Lang\Publisher\Plugins\SparkPaddle;
use LaravelLang\Lang\Publisher\Plugins\SparkStripe;
use Tests\TestCase;

class PluginsTest extends TestCase
{
    public function testHas()
    {
        $plugins = [
            Breeze::class      => true,
            Cashier::class     => true,
            Fortify::class     => true,
            Jetstream::class   => true,
            Laravel::class     => true,
            Nova::class        => true,
            SparkPaddle::class => true,
            SparkStripe::class => true,

            Lumen::class => false,
        ];

        foreach ($plugins as $plugin => $expected) {
            $this->testPlugin($plugin, $expected);
        }
    }

    protected function testPlugin(string $class, bool $expected)
    {
        /** @var \DragonCode\Contracts\LangPublisher\Plugin $instance */
        $instance = new $class();

        $actual = $instance->has();

        $this->assertSame($expected, $actual, $class);
    }
}
