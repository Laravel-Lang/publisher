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
use Tests\Fixtures\MorePlugins\Second\Src\Plugin as SecondProvider;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return array_merge(parent::getPackageProviders($app), [
            FirstProvider::class,
            SecondProvider::class,
        ]);
    }
}
