<?php

namespace Helldar\LaravelLangPublisher;

use Helldar\LaravelLangPublisher\Console\LangInstall;
use Helldar\LaravelLangPublisher\Console\LangUpdate;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->commands([
            LangInstall::class,
            LangUpdate::class,
        ]);
    }
}
