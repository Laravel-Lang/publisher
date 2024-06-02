<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelLang\Publisher\Concerns\About;
use LaravelLang\Publisher\Console\Add;
use LaravelLang\Publisher\Console\Remove;
use LaravelLang\Publisher\Console\Reset;
use LaravelLang\Publisher\Console\Update;

class ServiceProvider extends BaseServiceProvider
{
    use About;

    public function boot(): void
    {
        $this->bootCommands();
    }

    public function register(): void
    {
        $this->registerAbout();
    }

    protected function bootCommands(): void
    {
        $this->commands([
            Add::class,
            Remove::class,
            Reset::class,
            Update::class,
        ]);
    }
}
