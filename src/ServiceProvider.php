<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\LangInstall;
use Helldar\LaravelLangPublisher\Console\LangUpdate;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->bootPublishes();
        $this->bootCommands();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/lang-publisher.php', 'lang-publisher');
    }

    protected function bootCommands()
    {
        $this->commands([
            LangInstall::class,
            LangUpdate::class,
        ]);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__ . '/../config/lang-publisher.php' => $this->app->configPath('lang-publisher.php'),
        ], 'config');
    }
}
