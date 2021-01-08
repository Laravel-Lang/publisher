<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Support\Missing;
use Tests\TestCase;

class MissingTest extends TestCase
{
    public function testDiff()
    {
        $missing = new Missing();

        $locales = $missing->get();

        $this->assertIsArray($locales);
        $this->assertEmpty($locales);
    }
}
