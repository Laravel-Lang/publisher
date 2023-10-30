<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Config;

use LaravelLang\Publisher\Constants\Types;
use Tests\Fixtures\MorePlugins\Second\Src\Plugin as SecondPlugin;
use Tests\Fixtures\Plugin\src\Plugin;

class GetPackagesTest extends Base
{
    public function testGetPackages(): void
    {
        $this->assertSame(
            [
                realpath(__DIR__ . '/../../../Fixtures/Plugin') => [
                    Types::TypeClass->value => Plugin::class,
                    Types::TypeName->value  => 'some/name',
                ],

                realpath(__DIR__ . '/../../../Fixtures/MorePlugins/Second') => [
                    Types::TypeClass->value => SecondPlugin::class,
                    Types::TypeName->value  => 'some/many-second',
                ],
            ],
            $this->config->getPackages()
        );
    }
}
