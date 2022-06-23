<?php

declare(strict_types=1);

namespace Tests;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var array<string|LocaleCode> */
    protected array $preinstall = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->preInstallLocales();
    }

    protected function preInstallLocales(): void
    {
        if ($locales = $this->preinstall) {
            $locales = Arr::of($locales)
                ->map(static fn (string|LocaleCode $locale) => is_string($locale) ? $locale : $locale->value)
                ->toArray();

            $this->artisan('lang:add', compact('locales'));
        }
    }
}
