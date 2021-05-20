<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Plugins\Cashier;
use Helldar\LaravelLangPublisher\Plugins\Fortify;
use Helldar\LaravelLangPublisher\Plugins\Jetstream;
use Helldar\LaravelLangPublisher\Plugins\Nova;
use Helldar\LaravelLangPublisher\Plugins\SparkPaddle;
use Helldar\LaravelLangPublisher\Plugins\SparkStripe;
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
