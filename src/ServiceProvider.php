<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\LangInstall;
use Helldar\LaravelLangPublisher\Console\LangUpdate;
use Helldar\LaravelLangPublisher\Contracts\Filesystem as FilesystemContract;
use Helldar\LaravelLangPublisher\Contracts\Localization as PublisherContract;
use Helldar\LaravelLangPublisher\Services\Filesystem;
use Helldar\LaravelLangPublisher\Services\Localization;
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
        $this->binds();

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

    protected function binds()
    {
        $this->app->bind(FilesystemContract::class, Filesystem::class);
        $this->app->bind(PublisherContract::class, Localization::class);
    }
}
