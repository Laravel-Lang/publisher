<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\Add;
use Helldar\LaravelLangPublisher\Console\Remove;
use Helldar\LaravelLangPublisher\Console\Reset;
use Helldar\LaravelLangPublisher\Console\Update;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->bootPublishes();
        $this->bootCommands();
    }

    public function register(): void
    {
        $this->config();
    }

    protected function bootCommands(): void
    {
        $this->commands([
            Add::class,
            Reset::class,
            Remove::class,
            Update::class,
        ]);
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/public.php' => $this->app->configPath('lang-publisher.php'),
        ], 'config');
    }

    protected function config(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/public.php', Config::KEY_PUBLIC);
        $this->mergeConfigFrom(__DIR__ . '/../config/private.php', Config::KEY_PRIVATE);
    }
}
