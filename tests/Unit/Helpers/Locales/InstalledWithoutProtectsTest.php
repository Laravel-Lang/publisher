<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Locales;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class InstalledWithoutProtectsTest extends TestCase
{
    protected LocaleCode $fallback_locale = LocaleCode::FRENCH;

    public function testDefault(): void
    {
        $this->assertSame([
            LocaleCode::RUSSIAN->value,
        ], Locales::installedWithoutProtects());
    }

    public function testCustom(): void
    {
        $this->artisanLangAdd([
            LocaleCode::AFRIKAANS,
            LocaleCode::GERMAN,
        ]);

        $this->assertSame([
            LocaleCode::AFRIKAANS->value,
            LocaleCode::GERMAN->value,
            LocaleCode::RUSSIAN->value,
        ], Locales::installedWithoutProtects());
    }

    public function testProtected(): void
    {
        $this->artisanLangAdd([
            LocaleCode::GERMAN,
        ]);

        $this->assertSame([
            LocaleCode::GERMAN->value,
            LocaleCode::RUSSIAN->value,
        ], Locales::installedWithoutProtects());
    }

    /**
     * @param array<LocaleCode> $locales
     *
     * @return array
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
