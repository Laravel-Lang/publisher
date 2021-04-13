<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\Install;
use Helldar\LaravelLangPublisher\Console\Reset;
use Helldar\LaravelLangPublisher\Console\Uninstall;
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
            Install::class,
            Reset::class,
            Uninstall::class,
            Update::class,
        ]);
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/lang-publisher.php' => $this->app->configPath('lang-publisher.php'),
        ], 'config');
    }

    protected function config(): void
    {
        if ($this->isLumen()) {
            $this->app->configure(Config::KEY_PUBLIC);
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/lang-publisher.php', Config::KEY_PUBLIC);
        $this->mergeConfigFrom(__DIR__ . '/../config/settings.php', Config::KEY_PRIVATE);
    }

    protected function isLumen(): bool
    {
        return App::isLumen();
    }
}
