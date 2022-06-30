<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Config;

use Tests\Fixtures\MorePlugins\First\Src\Plugin as FirstProvider;
use Tests\Fixtures\MorePlugins\First\Src\Plugins\Bar as FirstBar;
use Tests\Fixtures\MorePlugins\First\Src\Plugins\Foo as FirstFoo;
use Tests\Fixtures\MorePlugins\Second\Src\Plugin as SecondProvider;
use Tests\Fixtures\MorePlugins\Second\Src\Plugins\Bar as SecondBar;
use Tests\Fixtures\MorePlugins\Second\Src\Plugins\Foo as SecondFoo;
use Tests\Fixtures\Plugin\src\Plugins\Baq;
use Tests\Fixtures\Plugin\src\Plugins\Bar;
use Tests\Fixtures\Plugin\src\Plugins\Baw;
use Tests\Fixtures\Plugin\src\Plugins\Custom;
use Tests\Fixtures\Plugin\src\Plugins\Foo;
use Tests\TestCase;

class GetPluginsTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return array_merge(parent::getPackageProviders($app), [
            FirstProvider::class,
            SecondProvider::class,
        ]);
    }

    public function testGetPlugins(): void
    {
        $this->assertSame([
            realpath(__DIR__ . '/../../../Fixtures/Plugin')             => [
                Baq::class,
                Bar::class,
                Baw::class,
                Custom::class,
                Foo::class,
            ],
            realpath(__DIR__ . '/../../../Fixtures/MorePlugins/First')  => [
                FirstBar::class,
                FirstFoo::class,
            ],
            realpath(__DIR__ . '/../../../Fixtures/MorePlugins/Second') => [
                SecondBar::class,
                SecondFoo::class,
            ],
        ], $this->config->getPlugins());
    }
}
