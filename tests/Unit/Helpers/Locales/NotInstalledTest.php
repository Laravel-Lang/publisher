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

namespace Tests\Unit\Helpers\Locales;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class NotInstalledTest extends TestCase
{
    protected LocaleCode $fallback_locale = LocaleCode::FRENCH;

    public function testDefault(): void
    {
        $expected = $this->except([
            LocaleCode::ENGLISH,
            LocaleCode::FRENCH,
            LocaleCode::RUSSIAN,
        ]);

        $this->assertSame($expected, Locales::notInstalled());
    }

    public function testCustom(): void
    {
        $this->artisanLangAdd([
            LocaleCode::AFRIKAANS,
            LocaleCode::GERMAN,
        ]);

        $expected = $this->except([
            LocaleCode::AFRIKAANS,
            LocaleCode::ENGLISH,
            LocaleCode::FRENCH,
            LocaleCode::GERMAN,
            LocaleCode::RUSSIAN,
        ]);

        $this->assertSame($expected, Locales::notInstalled());
    }

    public function testProtected(): void
    {
        $this->artisanLangAdd([
            LocaleCode::GERMAN,
        ]);

        $expected = $this->except([
            LocaleCode::ENGLISH,
            LocaleCode::FRENCH,
            LocaleCode::GERMAN,
            LocaleCode::RUSSIAN,
        ]);

        $this->assertSame($expected, Locales::notInstalled());
    }

    /**
     * @param  array<LocaleCode>  $locales
     */
    protected function except(array $locales): array
    {
        $locales = array_map(static fn (LocaleCode $locale) => $locale->value, $locales);

        return Arr::of(LocaleCode::values())
            ->filter(static fn (string $locale) => ! in_array($locale, $locales))
            ->sort()
            ->values()
            ->toArray();
    }
}
