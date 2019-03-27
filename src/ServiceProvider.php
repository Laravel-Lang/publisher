<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\LangInstall;
use Helldar\LaravelLangPublisher\Console\LangUpdate;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->commands([
            LangInstall::class,
            LangUpdate::class,
        ]);
    }
}
