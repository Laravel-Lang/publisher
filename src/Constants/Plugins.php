<?php

namespace Helldar\LaravelLangPublisher\Constants;

use Helldar\LaravelLangPublisher\Plugins\Cashier;
use Helldar\LaravelLangPublisher\Plugins\Fortify;
use Helldar\LaravelLangPublisher\Plugins\Jetstream;
use Helldar\LaravelLangPublisher\Plugins\Nova;
use Helldar\LaravelLangPublisher\Plugins\SparkPaddle;
use Helldar\LaravelLangPublisher\Plugins\SparkStripe;

final class Plugins
{
    public const ALL = [
        Cashier::class,
        Fortify::class,
        Jetstream::class,
        Nova::class,
        SparkPaddle::class,
        SparkStripe::class,
    ];
}
