<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Facades\Packages;
use Tests\TestCase;

class PackagesTest extends TestCase
{
    public function testAvailable()
    {
        $packages = [
            'andrey-helldar/lang-translations',
            'laravel-lang/lang',
        ];

        $this->assertSame($packages, Packages::get());
    }

    public function testPackagesList()
    {
        $this->setPackages([
            'a-foo/bar',
            'e-foo/bar',
            'b-foo/bar',
        ]);

        $packages = [
            'a-foo/bar',
            'e-foo/bar',
            'b-foo/bar',
            'laravel-lang/lang',
        ];

        $this->assertSame($packages, Packages::get());
    }
}
