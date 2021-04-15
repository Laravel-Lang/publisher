<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Facades\Packages;
use Helldar\LaravelLangPublisher\Services\Missing;
use Tests\TestCase;

class MissingTest extends TestCase
{
    public function testMissing()
    {
        foreach ($this->packages() as $package) {
            $locales = $this->service()->missing($package);

            $message = $this->message($package, $locales);

            $this->assertIsArray($locales, $message);
            $this->assertEmpty($locales, $message);
        }
    }

    public function testUnnecessary()
    {
        foreach ($this->packages() as $package) {
            $locales = $this->service()->unnecessary($package);

            $message = $this->message($package, $locales);

            $this->assertIsArray($locales, $message);
            $this->assertEmpty($locales, $message);
        }
    }

    protected function service(): Missing
    {
        return Missing::make();
    }

    protected function packages(): array
    {
        return Packages::filtered();
    }

    protected function message(string $package, array $locales): string
    {
        return '[' . $package . '] Locales: ' . $this->implode($locales);
    }

    protected function implode(array $array): string
    {
        return implode(', ', $array);
    }
}
