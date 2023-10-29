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

namespace Tests\Unit\Helpers\Locales;

use LaravelLang\Locales\Enums\Config;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use Tests\TestCase;

class IsAvailableTest extends TestCase
{
    public function testEach(): void
    {
        foreach (LocaleCode::values() as $locale) {
            $this->assertTrue(Locales::isAvailable($locale));
        }
    }

    public function testIncorrect(): void
    {
        $this->assertFalse(Locales::isAvailable('FOO'));
        $this->assertFalse(Locales::isAvailable('BAR'));

        $this->assertFalse(Locales::isAvailable('AA'));
        $this->assertFalse(Locales::isAvailable('BB'));

        $this->assertFalse(Locales::isAvailable('cc'));
        $this->assertFalse(Locales::isAvailable('dd'));
    }

    public function testAlias(): void
    {
        $this->app['config']->set(Config::PublicKey() . '.aliases', [
            LocaleCode::GERMAN->value => 'de-DE',
        ]);

        $this->assertTrue(Locales::isAvailable('de'));
        $this->assertTrue(Locales::isAvailable('de-DE'));
    }
}
