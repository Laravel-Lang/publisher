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

declare(strict_types=1);

namespace Tests\Unit\Console\InlineOff\Add;

use LaravelLang\Publisher\Exceptions\UnknownLocaleCodeException;
use Tests\Unit\Console\InlineOff\TestCase;

class IncorrectLocaleTest extends TestCase
{
    public function testAdd(): void
    {
        $this->expectException(UnknownLocaleCodeException::class);
        $this->expectExceptionMessage('Unknown locale code: foo.');

        $this->artisan('lang:add', ['locales' => 'foo'])->run();
    }
}
