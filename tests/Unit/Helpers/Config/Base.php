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

use Tests\Fixtures\MorePlugins\First\Src\Plugin as FirstProvider;
use Tests\Fixtures\MorePlugins\Second\Src\Plugin as SecondProvider;
use Tests\TestCase;

abstract class Base extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return array_merge(parent::getPackageProviders($app), [
            FirstProvider::class,
            SecondProvider::class,
        ]);
    }
}
