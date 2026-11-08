<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests\Fixtures\Plugin\src;

use LaravelLang\Publisher\Plugins\Provider;
use Tests\Fixtures\Plugin\src\Plugins\Baq;
use Tests\Fixtures\Plugin\src\Plugins\Bar;
use Tests\Fixtures\Plugin\src\Plugins\Baw;
use Tests\Fixtures\Plugin\src\Plugins\Custom;
use Tests\Fixtures\Plugin\src\Plugins\Foo;

class Plugin extends Provider
{
    protected ?string $package_name = 'some/name';

    protected string $base_path = __DIR__ . '/../';

    protected array $plugins = [
        Foo::class,
        Bar::class,
        Baq::class,
        Baw::class,
        Custom::class,
    ];

    public function boot(): void
    {
        $path = function_exists('lang_path') ? lang_path('vendor/baq') : resource_path('lang/vendor/baq');

        $this->loadJsonTranslationsFrom($path);
    }
}
