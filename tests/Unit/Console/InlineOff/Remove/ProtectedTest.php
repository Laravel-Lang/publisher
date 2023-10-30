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

use LaravelLang\Locales\Enums\Locale;
use LaravelLang\Publisher\Exceptions\ProtectedLocaleException;
use Tests\Unit\Console\InlineOff\TestCase;

class ProtectedTest extends TestCase
{
    public function testDefault(): void
    {
        $this->expectException(ProtectedLocaleException::class);
        $this->expectExceptionMessage('Can\'t delete protected locales: en.');

        $this->artisanLangRemove(Locale::English);
    }

    public function testFallback(): void
    {
        $this->expectException(ProtectedLocaleException::class);
        $this->expectExceptionMessage('Can\'t delete protected locales: fr.');

        $this->artisanLangRemove(Locale::French);
    }

    public function testMixed(): void
    {
        $this->expectException(ProtectedLocaleException::class);
        $this->expectExceptionMessage('Can\'t delete protected locales: en.');

        $this->artisanLangRemove([
            Locale::Afrikaans,
            Locale::English,
            Locale::French,
            Locale::German,
            Locale::NorwegianBokmal,
        ]);
    }
}
