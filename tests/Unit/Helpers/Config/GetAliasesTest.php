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

namespace Tests\Unit\Helpers\Config;

use LaravelLang\Locales\Enums\Config;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;

class GetAliasesTest extends Base
{
    protected array $preinstall = [
        LocaleCode::GERMAN,
        LocaleCode::GERMAN_SWITZERLAND,
    ];

    public function testInstalled(): void
    {
        $this->assertSame([
            'de-CH',
            'de-DE',
            'en',
            'fr',
            'ru',
        ], Locales::installed());
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set(Config::PublicKey() . '.aliases', [
            LocaleCode::GERMAN->value => 'de-DE',

            LocaleCode::GERMAN_SWITZERLAND->value => 'de-CH',
        ]);
    }
}
