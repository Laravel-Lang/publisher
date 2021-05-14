<?php

namespace Helldar\LaravelLangPublisher\Constants;

use Helldar\LaravelLangPublisher\Packages\Cashier;
use Helldar\LaravelLangPublisher\Packages\Fortify;
use Helldar\LaravelLangPublisher\Packages\Jetstream;
use Helldar\LaravelLangPublisher\Packages\Nova;
use Helldar\LaravelLangPublisher\Packages\SparkPaddle;
use Helldar\LaravelLangPublisher\Packages\SparkStripe;

final class Packages
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
