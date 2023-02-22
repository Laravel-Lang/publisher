<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Config;

use LaravelLang\Publisher\Constants\Types;
use Tests\Fixtures\MorePlugins\Second\Src\Plugin as SecondPlugin;
use Tests\Fixtures\Plugin\src\Plugin;

class GetPackageNameByPathTest extends Base
{
    public function testName(): void
    {
        $this->assertSame('some/name', $this->config->getPackageNameByPath(__DIR__ . '/../../../Fixtures/Plugin'));
        $this->assertSame('some/many-second', $this->config->getPackageNameByPath(__DIR__ . '/../../../Fixtures/MorePlugins/Second'));
    }

    public function testClass(): void
    {
        $this->assertSame(Plugin::class, $this->config->getPackageNameByPath(__DIR__ . '/../../../Fixtures/Plugin', Types::TYPE_CLASS));
        $this->assertSame(SecondPlugin::class, $this->config->getPackageNameByPath(__DIR__ . '/../../../Fixtures/MorePlugins/Second', Types::TYPE_CLASS));
    }

    public function testUnknownPackage(): void
    {
        $this->assertSame(
            realpath(__DIR__ . '/../../../Fixtures/MorePlugins/First'),
            $this->config->getPackageNameByPath(__DIR__ . '/../../../Fixtures/MorePlugins/First')
        );

        $this->assertSame(
            realpath(__DIR__ . '/../../../Fixtures/MorePlugins/First'),
            $this->config->getPackageNameByPath(__DIR__ . '/../../../Fixtures/MorePlugins/First', Types::TYPE_CLASS)
        );
    }
}
