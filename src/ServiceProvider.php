<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\LangInstall;
use Helldar\LaravelLangPublisher\Console\LangUninstall;
use Helldar\LaravelLangPublisher\Console\LangUpdate;
use Helldar\LaravelLangPublisher\Support\Config;
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
            LangInstall::class,
            LangUpdate::class,
            LangUninstall::class,
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
        $this->mergeConfigFrom(__DIR__ . '/../config/lang-publisher.php', Config::KEY);
    }
}
