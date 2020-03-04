<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\LangInstall;
use Helldar\LaravelLangPublisher\Console\LangUninstall;
use Helldar\LaravelLangPublisher\Console\LangUpdate;
use Helldar\LaravelLangPublisher\Contracts\Arr as ArrContract;
use Helldar\LaravelLangPublisher\Contracts\Config as ConfigContract;
use Helldar\LaravelLangPublisher\Contracts\File as FileContract;
use Helldar\LaravelLangPublisher\Contracts\Locale as LocaleContract;
use Helldar\LaravelLangPublisher\Contracts\Localization as PublisherContract;
use Helldar\LaravelLangPublisher\Contracts\Path as PathContract;
use Helldar\LaravelLangPublisher\Services\Localization;
use Helldar\LaravelLangPublisher\Support\Arr;
use Helldar\LaravelLangPublisher\Support\Config;
use Helldar\LaravelLangPublisher\Support\File;
use Helldar\LaravelLangPublisher\Support\Locale;
use Helldar\LaravelLangPublisher\Support\Path;
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
        $this->binds();
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

    protected function binds(): void
    {
        $this->app->bind(FileContract::class, File::class);
        $this->app->bind(PublisherContract::class, Localization::class);
        $this->app->bind(LocaleContract::class, Locale::class);
        $this->app->bind(PathContract::class, Path::class);
        $this->app->bind(ArrContract::class, Arr::class);
    }

    protected function config(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/lang-publisher.php', ConfigContract::KEY);

        $this->app->singleton(ConfigContract::class, function () {
            return new Config();
        });
    }
}
