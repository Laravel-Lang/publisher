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

namespace Tests\Fixtures\Plugin\src;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelLang\Publisher\Plugins\Provider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        if (class_exists(Provider::class)) {
            $this->app->register(Plugin::class);
        }
    }
}
