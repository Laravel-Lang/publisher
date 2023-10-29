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

namespace Tests\Fixtures\MorePlugins\First\Src;

use LaravelLang\Publisher\Plugins\Provider;
use Tests\Fixtures\MorePlugins\First\Src\Plugins\Bar;
use Tests\Fixtures\MorePlugins\First\Src\Plugins\Foo;

class Plugin extends Provider
{
    protected string $base_path = __DIR__ . '/../';

    protected array $plugins = [
        Foo::class,
        Bar::class,
    ];
}
