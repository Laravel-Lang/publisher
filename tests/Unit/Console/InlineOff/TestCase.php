<?php

declare(strict_types=1);

namespace Tests\Unit\Console\InlineOff;

use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected bool $inline = false;
}
