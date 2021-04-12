<?php

namespace Tests\Console;

use Tests\TestCase;

class MissingTest extends TestCase
{
    public function testGreat()
    {
        $this->artisan('lang:missing')
            ->expectsOutput('All localizations are available!')
            ->assertExitCode(0);
    }
}
