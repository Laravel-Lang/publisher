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

namespace Tests\Unit\Helpers\Locales;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class InstalledTest extends TestCase
{
    protected LocaleCode $fallback_locale = LocaleCode::ENGLISH;

    public function testDefault(): void
    {
        $this->artisanLangRemove(LocaleCode::FRENCH);

        $this->assertSame([
            LocaleCode::ENGLISH->value,
            LocaleCode::RUSSIAN->value,
        ], Locales::installed());
    }

    public function testCustom(): void
    {
        $this->artisanLangAdd([
            LocaleCode::GERMAN,
            LocaleCode::FRENCH,
        ]);

        $this->assertSame([
            LocaleCode::GERMAN->value,
            LocaleCode::ENGLISH->value,
            LocaleCode::FRENCH->value,
            LocaleCode::RUSSIAN->value,
        ], Locales::installed());
    }

    public function testProtected(): void
    {
        $this->artisanLangAdd([
            LocaleCode::GERMAN,
        ]);

        config(['app.fallback_locale' => LocaleCode::FRENCH->value]);

        $this->assertSame([
            LocaleCode::GERMAN->value,
            LocaleCode::ENGLISH->value,
            LocaleCode::FRENCH->value,
            LocaleCode::RUSSIAN->value,
        ], Locales::installed());
    }

    public function testFileTraces(): void
    {
        File::store($this->config->langPath('vendor/traces/de.json'), '[]');

        $this->assertSame([
            LocaleCode::GERMAN->value,
            LocaleCode::ENGLISH->value,
            LocaleCode::FRENCH->value,
            LocaleCode::RUSSIAN->value,
        ], Locales::installed());
    }

    public function testDirectoryTraces(): void
    {
        Directory::ensureDirectory($this->config->langPath('de'));

        $this->assertSame([
            LocaleCode::GERMAN->value,
            LocaleCode::ENGLISH->value,
            LocaleCode::FRENCH->value,
            LocaleCode::RUSSIAN->value,
        ], Locales::installed());
    }
}
