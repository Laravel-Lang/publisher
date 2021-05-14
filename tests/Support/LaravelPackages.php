<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Packages\Cashier;
use Helldar\LaravelLangPublisher\Packages\Fortify;
use Helldar\LaravelLangPublisher\Packages\Jetstream;
use Helldar\LaravelLangPublisher\Packages\Nova;
use Helldar\LaravelLangPublisher\Packages\SparkPaddle;
use Helldar\LaravelLangPublisher\Packages\SparkStripe;
use Tests\TestCase;

final class LaravelPackages extends TestCase
{
    public function testInstalled()
    {
        $this->assertFalse(Cashier::make()->has());
        $this->assertFalse(SparkPaddle::make()->has());

        $this->assertTrue(Fortify::make()->has());
        $this->assertTrue(Jetstream::make()->has());
        $this->assertTrue(Nova::make()->has());
        $this->assertTrue(SparkStripe::make()->has());
    }
}
