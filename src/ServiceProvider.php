<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\Add;
use Helldar\LaravelLangPublisher\Console\Reset;
use Helldar\LaravelLangPublisher\Console\Remove;
use Helldar\LaravelLangPublisher\Console\Update;
use Helldar\LaravelLangPublisher\Support\Config;
use Helldar\LaravelSupport\Facades\App;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
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
        if ($this->isLumen()) {
            $this->app->configure(Config::KEY_PUBLIC);
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/public.php', Config::KEY_PUBLIC);
        $this->mergeConfigFrom(__DIR__ . '/../config/private.php', Config::KEY_PRIVATE);
    }

    protected function isLumen(): bool
    {
        return App::isLumen();
    }
}
