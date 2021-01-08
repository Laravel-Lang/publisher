<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\Helpers\Missing;
use Helldar\LaravelLangPublisher\Console\LangInstall;
use Helldar\LaravelLangPublisher\Console\LangReset;
use Helldar\LaravelLangPublisher\Console\LangUninstall;
use Helldar\LaravelLangPublisher\Console\LangUpdate;
use Helldar\LaravelLangPublisher\Support\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Lumen\Application;

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
            LangReset::class,
            LangUninstall::class,
            LangUpdate::class,
            Missing::class,
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
            $this->app->configure(Config::KEY);
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/lang-publisher.php', Config::KEY);
        $this->mergeConfigFrom(__DIR__ . '/../config/settings.php', Config::KEY_PRIVATE);
    }

    protected function isLumen(): bool
    {
        return class_exists(Application::class) && $this->app instanceof Application;
    }
}
