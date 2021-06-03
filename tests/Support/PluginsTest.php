<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Plugins\Breeze;
use Helldar\LaravelLangPublisher\Plugins\Cashier;
use Helldar\LaravelLangPublisher\Plugins\Fortify;
use Helldar\LaravelLangPublisher\Plugins\Framework;
use Helldar\LaravelLangPublisher\Plugins\Jetstream;
use Helldar\LaravelLangPublisher\Plugins\Lumen;
use Helldar\LaravelLangPublisher\Plugins\Nova;
use Helldar\LaravelLangPublisher\Plugins\SparkPaddle;
use Helldar\LaravelLangPublisher\Plugins\SparkStripe;
use Tests\TestCase;

final class PluginsTest extends TestCase
{
    public function testInstalled()
    {
        $this->assertFalse(Breeze::make()->has());
        $this->assertFalse(Cashier::make()->has());
        $this->assertFalse(SparkPaddle::make()->has());
        $this->assertFalse(Lumen::make()->has());

        $this->assertTrue(Framework::make()->has());
        $this->assertTrue(Fortify::make()->has());
        $this->assertTrue(Jetstream::make()->has());
        $this->assertTrue(Nova::make()->has());
        $this->assertTrue(SparkStripe::make()->has());
    }
}
