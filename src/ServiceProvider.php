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

namespace LaravelLang\Publisher;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelLang\Publisher\Console\Add;
use LaravelLang\Publisher\Console\Update;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->bootCommands();
    }

    protected function bootCommands(): void
    {
        $this->commands([
            Add::class,
            Update::class,
        ]);
    }
}
