<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
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
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelLang\Lang\ServiceProvider as LangServiceProvider;
use LaravelLang\Publisher\Console\Add;
use LaravelLang\Publisher\Console\Remove;
use LaravelLang\Publisher\Console\Reset;
use LaravelLang\Publisher\Console\Update;
use LaravelLang\Publisher\Constants\Config;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->bootPublishes();
        $this->bootCommands();
    }

    public function register(): void
    {
        $this->registerConfig();
        $this->registerLaravelLang();
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
            __DIR__ . '/../config/public.php' => $this->app->configPath(Config::PUBLIC_KEY . '.php'),
        ], 'config');
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/public.php', Config::PUBLIC_KEY);
        $this->mergeConfigFrom(__DIR__ . '/../config/private.php', Config::PRIVATE_KEY);
    }

    protected function registerLaravelLang(): void
    {
        if (class_exists(LangServiceProvider::class)) {
            $this->app->register(LangServiceProvider::class);
        }
    }
}
