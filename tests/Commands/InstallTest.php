<?php

namespace Tests\Commands;

use Tests\TestCase;

class InstallTest extends TestCase
{
    public function testCanInstallWithNoForce()
    {
        $lang = ['de', 'ru', 'fr', 'zh-CN'];

        $this->artisan('lang:install', \compact('lang'))
            ->assertExitCode(0);
    }
}
