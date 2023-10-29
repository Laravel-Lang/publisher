<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests\Unit\Console\InlineOff\Remove;

use LaravelLang\Publisher\Exceptions\UnknownLocaleCodeException;
use Tests\Unit\Console\InlineOff\TestCase;

class IncorrectLocaleTest extends TestCase
{
    public function testRemove(): void
    {
        $this->expectException(UnknownLocaleCodeException::class);
        $this->expectExceptionMessage('Unknown locale code: foo.');

        $this->artisan('lang:rm', ['locales' => 'foo'])->run();
    }
}
