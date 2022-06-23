<?php

declare(strict_types=1);

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected array $preinstall = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->preInstallLocales();
    }

    protected function preInstallLocales(): void
    {
        if (! empty($this->preinstall)) {
            $this->artisan('lang:add', ['locales' => $this->preinstall]);
        }
    }
}
