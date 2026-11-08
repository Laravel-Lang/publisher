<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use LaravelLang\Publisher\Helpers\KeySorter;
use PHPUnit\Framework\TestCase;

class KeySorterTest extends TestCase
{
    public function testIgnoresCaseAndSortsRecursively(): void
    {
        $sorted = KeySorter::sort([
            'Zeta'  => 1,
            'alpha' => 1,
            'Beta'  => ['b' => 1, 'A' => 1],
        ]);

        $this->assertSame(['alpha', 'Beta', 'Zeta'], array_keys($sorted));
        $this->assertSame(['A', 'b'], array_keys($sorted['Beta']));
    }

    public function testSingleSymbolKeysComeBeforeNumbers(): void
    {
        $this->assertSame(
            ['-', 1, 2, 10],
            array_keys(KeySorter::sort([10 => 'a', 2 => 'b', 1 => 'c', '-' => 'd']))
        );
    }
}
