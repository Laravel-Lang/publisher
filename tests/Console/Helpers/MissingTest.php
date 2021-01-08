<?php

namespace Tests\Console\Helpers;

use Tests\TestCase;

class MissingTest extends TestCase
{
    public function testGreat()
    {
        $this->artisan('lang:missing')
            ->expectsOutput('Congratulations! All localizations are available!')
            ->assertExitCode(0);
    }
}
