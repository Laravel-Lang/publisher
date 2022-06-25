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

namespace Tests\Unit\Console\InlineOff\Remove;

use LaravelLang\Publisher\Constants\Locales;
use LaravelLang\Publisher\Exceptions\ProtectedLocaleException;
use Tests\Unit\Console\InlineOff\TestCase;

class ProtectedTest extends TestCase
{
    protected Locales $fallback_locale = Locales::FRENCH;

    public function testDefault(): void
    {
        $this->expectException(ProtectedLocaleException::class);
        $this->expectExceptionMessage('Can\'t delete protected locales: en.');

        $this->artisan('lang:rm', [
            'locales' => [Locales::ENGLISH],
        ])->run();
    }

    public function testFallback(): void
    {
        $this->expectException(ProtectedLocaleException::class);
        $this->expectExceptionMessage('Can\'t delete protected locales: fr.');

        $this->artisan('lang:rm', [
            'locales' => [Locales::FRENCH],
        ])->run();
    }

    public function testMixed(): void
    {
        $this->expectException(ProtectedLocaleException::class);
        $this->expectExceptionMessage('Can\'t delete protected locales: en, fr.');

        $this->artisan('lang:rm', [
            'locales' => [
                Locales::AFRIKAANS,
                Locales::ENGLISH,
                Locales::FRENCH,
                Locales::GERMAN,
                Locales::NORWEGIAN_BOKMAL,
            ],
        ])->run();
    }
}
