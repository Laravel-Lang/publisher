<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

namespace Tests\Unit\Helpers\Locales;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class AvailableTest extends TestCase
{
    public function testList(): void
    {
        $this->assertSame(Arr::sort(LocaleCode::values()), Locales::available());
    }
}
