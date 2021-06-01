<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Support\Config;

abstract class TestCaseInline extends TestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set(Config::KEY_PUBLIC . '.inline', false);
    }
}
