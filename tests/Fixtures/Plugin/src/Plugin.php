<?php

/*
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

namespace Tests\Fixtures\Plugin\src;

use LaravelLang\Publisher\Plugins\Provider;
use Tests\Fixtures\Plugin\src\Plugins\Baq;
use Tests\Fixtures\Plugin\src\Plugins\Bar;
use Tests\Fixtures\Plugin\src\Plugins\Baw;
use Tests\Fixtures\Plugin\src\Plugins\Foo;

class Plugin extends Provider
{
    protected string $base_path = __DIR__ . '/../../';

    protected array $plugins = [
        Foo::class,
        Bar::class,
        Baq::class,
        Baw::class,
    ];
}
