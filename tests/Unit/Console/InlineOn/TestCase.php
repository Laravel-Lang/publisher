<?php

declare(strict_types=1);

namespace Tests\Unit\Console\InlineOn;

use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected bool $inline = true;
}
